<?php
/**
 * Controller for file
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\FileEntity;

class FileController extends AppController {

    public function import(string $category, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        $name = $_FILES['file']['name'];
        $content = file_get_contents($_FILES['file']['tmp_name']);
        $analyzable = true; // TO CHANGE

        $file_entity = new FileEntity;
        $res = $file_entity->importFile($category, $name, $content, $projectId, $analyzable);

        $this->redirect('/project/view/' . $projectId);
    }

    public function delete(string $category, int $fileId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        $file_entity = new FileEntity;
        $res = $file_entity->delete($category, $fileId);

        $this->redirect('/project/view/' . $projectId);
    }

    public function download(string $category, int $fileId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        $file_entity = new FileEntity;
        $file = $file_entity->getFile($category, $fileId);

        $file_name = $file['nom'];
        $file_content = $file['fichier'];
        $f = fopen($file_name, 'w');
        fwrite($f, $file_content);
        fclose($f);
        header("Content-disposition: attachment;filename=$file_name");
        readfile($file_name);
    }

}
