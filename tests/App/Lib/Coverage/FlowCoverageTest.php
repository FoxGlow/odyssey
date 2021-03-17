<?php

namespace Tests\App\Lib\Coverage;

use App\Lib\Coverage\FlowCoverage;
use PHPUnit\Framework\TestCase;

class FlowCoverageTest extends TestCase {

    public function testWithBadCoverage() {
        $flow_coverage = new FlowCoverage(file_get_contents('diagramIncorrect.bpmn'), file_get_contents('MCF_correct.drawio'));
        $this->assertEquals($flow_coverage->getFlows(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun probème détecté")
        ));
    }

    public function testWithGoodCoverage() {
        $flow_coverage = new FlowCoverage(file_get_contents('diagramCorrect.bpmn'), file_get_contents('MCF_correct.drawio'));
        $this->assertEquals($flow_coverage->getFlows(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun probème détecté")
        ));
    }

}
