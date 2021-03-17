<?php

namespace Tests\App\Lib\DrawIO;

use App\Lib\DrawIO\MCFAnalyzer;
use PHPUnit\Framework\TestCase;

class MCFAnalyzerTest extends TestCase {

    private $mcf_analyzer;

    protected function setUp() {
        $this->mcf_analyzer = new MCFAnalyzer;
    }

    public function testFlowsWithCorrectFile() {
        $this->mcf_analyzer->loadFileContent(file_get_contents('MCF_correct.drawio'));
        $this->assertEquals($this->mcf_analyzer->getFlows(), array(
            'F01. coordonnées', 'F02. notification'
        ));
    }

    public function testFlowsWithIncorrectFile() {
        $this->mcf_analyzer->loadFileContent(file_get_contents('MCF_faux.drawio'));
        $this->assertEquals($this->mcf_analyzer->getFlows(), array(
            'F01. coordonnées', 'F02. notification'
        ));
    }

}
