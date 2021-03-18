<?php
/**
 * Class to cover activity consistency between StoryMap file and Bpmn file
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

namespace App\Lib\Coverage;

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
    private function analyzeConsistency(array $bpmn_activities, array $storyMap_epics) : array {
        $number_covered = 0;
        $missing_storyMap_epic_in_bpmn = array();

        $result = array("Coverage" => 0, "Feedbacks" => array());
        
        foreach($storyMap_epics as $storyMap_epic) {
            $covered = false;
            foreach ($bpmn_activities as $bpmn_activity) {
                if ($storyMap_epic == $bpmn_activity)
                    $number_covered++;
                    $covered = true;
            }
            if (!$covered)
                array_push($missing_storyMap_epic_in_bpmn, $storyMap_epic);
        }

        if ($number_covered == count($storyMap_epics)) {
            $result["Coverage"] = 100;
            array_push($result["Feedbacks"], "Aucun problème détecté, toutes les épics sont présentes dans le bpmn");
            return $result;
        }

        else {
                array_push($result["Feedbacks"], "il y'a des épics manquantes dans le bpmn");
            
            $size = count($storyMap_epics);
            $result["Coverage"] = $number_covered*100/$size; 

            foreach ($missing_storyMap_epic_in_bpmn as $epic)
                array_push ($result["Feedbacks"], "L'épic {$epic} de la story map n'apparait pas dans le BPMN");
            
            return $result;
        } 
    }

}