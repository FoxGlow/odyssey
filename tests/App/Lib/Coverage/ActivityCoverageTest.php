<?php

namespace Tests\App\Lib\Coverage;

use App\Lib\Coverage\ActivityCoverage;
use PHPUnit\Framework\TestCase;

class ActivityCoverageTest extends TestCase {

    public function testWithBadCoverage() {
        $activity_coverage = new ActivityCoverage(file_get_contents('tests/App/Lib/Coverage/diagramIncorrect.bpmn'), file_get_contents('tests/App/Lib/Coverage/STORYMAP_faux.drawio'));
        $this->assertNotEquals($activity_coverage->analyzeCoverage(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun problème détecté, toutes les épics sont présentes dans le bpmn")
        ));
    }

    public function testWithGoodCoverage() {
        $activity_coverage = new ActivityCoverage(file_get_contents('tests/App/Lib/Coverage/diagramCorrect.bpmn'), file_get_contents('tests/App/Lib/Coverage/STORYMAP_correct.drawio'));
        $this->assertEquals($activity_coverage->analyzeCoverage(), array(
            "Coverage" => 100, "Feedbacks" => array("Aucun problème détecté, toutes les épics sont présentes dans le bpmn")
        ));
    }

}
