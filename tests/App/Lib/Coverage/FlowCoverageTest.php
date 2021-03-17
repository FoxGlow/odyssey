<?php

namespace Tests\App\Lib\Coverage;

use App\Lib\Coverage\FlowCoverage;
use PHPUnit\Framework\TestCase;

class FlowCoverageTest extends TestCase {

    public function testWithBadCoverage() {
        $flow_coverage = new FlowCoverage(file_get_contents('tests/App/Lib/Coverage/diagramIncorrect.bpmn'), file_get_contents('tests/App/Lib/Coverage/MCF_correct.drawio'));
        $this->assertNotEquals($flow_coverage->analyzeCoverage(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun probème détecté")
        ));
    }

    public function testWithGoodCoverage() {
        $flow_coverage = new FlowCoverage(file_get_contents('tests/App/Lib/Coverage/diagramCorrect.bpmn'), file_get_contents('tests/App/Lib/Coverage/MCF_correct.drawio'));
        $this->assertEquals($flow_coverage->analyzeCoverage(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun probème détecté")
        ));
    }

}
