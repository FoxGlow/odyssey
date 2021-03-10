<?php
/**
 * Class to cover activity consistency between StoryMap file and Bpmn file
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

namespace App\Lib\Coverage;

//require '../DrawIO/BPMNAnalyzer.php'; //for testing purpose
//require '../DrawIO/StoryMapAnalyzer.php'; //for testing purpose

use App\Lib\BPMNIO\BPMNAnalyzer;
use App\Lib\DrawIO\StoryMapAnalyzer;

class ActivityCoverage {

    /**
     * @var App\Lib\BPMNIO\BPMNAnalyzer
     */
    private $bpmn_analyzer;

    /**
     * @var App\Lib\DrawIO\StoryMapAnalyzer;
     */
    private $storyMap_analyzer;

    public function __construct(string $bpmn_content, string $storyMap_content) {
        $this->bpmn_analyzer = new BPMNAnalyzer;
        $this->storyMap_analyzer = new StoryMapAnalyzer;

        $this->bpmn_analyzer->loadFileContent($bpmn_content);
        $this->storyMap_analyzer->loadFileContent($storyMap_content);
    }

    public function analyzeCoverage() : array {
        $bpmn_activities = $this->bpmn_analyzer->getActivities();
        $storyMap_epics = $this->storyMap_analyzer->getEpics();
        
        return $this->analyzeConsistency($bpmn_activities, $storyMap_epics);
    }

    /**
     * Checks consistency between bpmn'activities and storyMap'epics
     * @param array $bpmn_activities the list of bpmn activities
     * @param array $storyMap_epics the list of storyMap epics
     * @return array An array containing the coverage percentage and a list of feedbacks
     */
    public function analyzeConsistency(array $bpmn_activities, array $storyMap_epics) : array {
        $number_covered = 0;
        $different_size = false;
        $missing_bpmn_activity_in_storyMap = array();
        $missing_storyMap_epic_in_bpmn = array();

        $result = array("Coverage" => 0, "Feedbacks" => array());
        
        if (count($bpmn_activities) != count($storyMap_epics))
           $different_size = true;

        foreach ( $bpmn_activities as $bpmn_activity) {
            $covered = false;
            foreach ($storyMap_epics as $storyMap_epic) {
                if ($bpmn_activity == $storyMap_epic) {
                    $number_covered++;
                    $covered = true;
                }
            }
            if (!$covered)
                array_push($missing_bpmn_activity_in_storyMap, $bpmn_activity);
        }

        foreach($storyMap_epics as $storyMap_epic) {
            $covered = false;
            foreach ($bpmn_activities as $bpmn_activity) {
                if ($storyMap_epic == $bpmn_activity)
                    $covered = true;
            }
            if (!$covered)
                array_push($missing_storyMap_epic_in_bpmn, $storyMap_epic);
        }

        if ($number_covered == count($bpmn_activities) && $different_size == false) {
            $result["Coverage"] = 100;
            array_push($result["Feedbacks"], "Aucun problème détecté");
            return $result;
        }

        else {
            if ($different_size)
                array_push($result["Feedbacks"], "Nombre d'activités est différent du nombre d'épics");
            
            $size = max(count($bpmn_activities), count($storyMap_epics));
            array_push($result["Coverage"], $number_covered*100/$size);

            foreach ($missing_bpmn_activity_in_storyMap as $activity)
                array_push ($result["Feedbacks"], "L'activité {$activity} du BPMN n'apparait pas dans la story map");

            foreach ($missing_storyMap_epic_in_bpmn as $epic)
                array_push ($result["Feedbacks"], "L'épic {$epic} de la story map n'apparait pas dans le BPMN");
            
            return $result;
        } 
    }

}