<?php
/**
 * Controller for file
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\FeedbackEntity;
use App\Entities\FileEntity;
use App\Lib\Coverage\ActivityCoverage;
use App\Lib\Coverage\FlowCoverage;

class FileController extends AppController {

    private function addFeedback(array $feedback, string $type, int $projectId) {
        $feedback_entity = new FeedbackEntity;
        if ($feedback_entity->exist($type, $projectId))
            $feedback_entity->delete($type, $projectId);
        $feedback_entity->add($type, implode('\n', $feedback['Feedbacks']), $feedback['Coverage'], $projectId);
    }

    private function deleteFeedbackAssociated(string $category, int $projectId) {
        $feedback_entity = new FeedbackEntity;
        switch ($category) {
            case 'mcf':
                if ($feedback_entity->exist('flow', $projectId))
                    $feedback_entity->delete('flow', $projectId);
                break;
            case 'bpmn':
                if ($feedback_entity->exist('flow', $projectId))
                    $feedback_entity->delete('flow', $projectId);
                if ($feedback_entity->exist('activity', $projectId))
                    $feedback_entity->delete('activity', $projectId);
                break;
            case 'story_map':
                if ($feedback_entity->exist('activity', $projectId))
                    $feedback_entity->delete('activity', $projectId);
                break;
        }
    }

    public function import(string $category, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');

        $file_entity = new FileEntity;
        if ($file_entity->exist($category, $projectId))
            $this->redirect('/project/view/' . $projectId);

        $name = $_FILES['file']['name'];
        $content = file_get_contents($_FILES['file']['tmp_name']);

        $file_entity->importFile($category, $name, $content, $projectId);

        // Is it possible to analyze ?
        switch ($category) {
            case "mcf":
                if ($file_entity->exist("bpmn", $projectId)) {
                    $bpmn = $file_entity->getFileForProject("bpmn", $projectId);
                    $flow_coverage = new FlowCoverage($bpmn['fichier'], $content);
                    $feedback = $flow_coverage->analyzeCoverage();
                    $this->addFeedback($feedback, 'flow', $projectId);
                }
                break;
            case "bpmn":
                if ($file_entity->exist("mcf", $projectId)) {
                    $mcf = $file_entity->getFileForProject("mcf", $projectId);
                    $flow_coverage = new FlowCoverage($content, $mcf['fichier']);
                    $feedback = $flow_coverage->analyzeCoverage();
                    $this->addFeedback($feedback, 'flow', $projectId);
                }
                if ($file_entity->exist("story_map", $projectId)) {
                    $story_map = $file_entity->getFileForProject("story_map", $projectId);
                    $activity_coverage = new ActivityCoverage($content, $story_map['fichier']);
                    $feedback = $activity_coverage->analyzeCoverage();
                    $this->addFeedback($feedback, 'activity', $projectId);
                }
                break;
            case "story_map":
                if ($file_entity->exist("bpmn", $projectId)) {
                    $bpmn = $file_entity->getFileForProject("bpmn", $projectId);
                    $activity_coverage = new ActivityCoverage($bpmn['fichier'], $content);
                    $feedback = $activity_coverage->analyzeCoverage();
                    $this->addFeedback($feedback, 'activity', $projectId);
                }
                break;
        }

        $this->redirect('/project/view/' . $projectId);
    }

    public function delete(string $category, int $fileId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');

        $file_entity = new FileEntity;
        if ($file_entity->exist($category, $projectId)) {
            $res = $file_entity->delete($category, $fileId);
            $this->deleteFeedbackAssociated($category, $projectId);
        }

        $this->redirect('/project/view/' . $projectId);
    }

    public function download(string $category, int $fileId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');
            
        $file_entity = new FileEntity;
        if ($file_entity->exist($category, $projectId)) {
            $file = $file_entity->getFile($category, $fileId);
            $file_name = $file['nom'];
            $file_content = $file['fichier'];
            $f = fopen($file_name, 'w');
            fwrite($f, $file_content);
            fclose($f);
            header("Content-disposition: attachment;filename=$file_name");
            readfile($file_name);
        }
        else {
            $this->redirect('/project/view/' . $projectId);
        }
    }

}
