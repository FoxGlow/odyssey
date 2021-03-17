<?php

namespace Tests\App\Lib\BPMNIO;

use App\Lib\BPMNIO\BPMNAnalyzer;
use PHPUnit\Framework\TestCase;

class BPMNAnalyzerTest extends TestCase {
    
    private $bpmn_analyzer;

    protected function setUp() {
        $this->bpmn_analyzer = new BPMNAnalyzer;
    }

    public function testFlowsWithCorrectFile(){
        $this->bpmn_analyzer->loadFileContent(file_get_contents('diagramCorrect.bpmn'));
        $this->assertEquals($this->bpmn_analyzer->getFlows(), array(
            'F01. coordonnées', 'F02. notification' 
        ));
    }

    public function testActivitiesWithCorrectFile(){
        $this->bpmn_analyzer->loadFileContent(file_get_contents('diagramCorrect.bpmn'));
        $this->assertEquals($this->bpmn_analyzer->getActivities(), array(
            "T01. s'inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

    public function testFlowsWithIncorrectFile(){
        $this->bpmn_analyzer->loadFileContent(file_get_contents('diagramIncorrect.bpmn'));
        $this->assertEquals($this->bpmn_analyzer->getFlows(), array(
            'F01. coordonnées', 'F02. notification' 
        ));
    }

    public function testActivitiesWithIncorrectFile(){
        $this->bpmn_analyzer->loadFileContent(file_get_contents('diagramIncorrec.bpmn'));
        $this->assertEquals($this->bpmn_analyzer->getActivities(), array(
            "T01. s'inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

}
