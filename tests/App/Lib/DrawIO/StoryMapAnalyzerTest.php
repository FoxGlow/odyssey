<?php

namespace Tests\App\Lib\DrawIO;

use App\Lib\DrawIO\StoryMapAnalyzer;
use PHPUnit\Framework\TestCase;

class StoryMapAnalyzerTest extends TestCase {

    private $story_map_analyzer;

    protected function setUp() {
        $this->story_map_analyzer = new MCFAnalyzer;
    }

    public function testFlowsWithCorrectFile() {
        $this->story_map_analyzer->loadFileContent(file_get_contents('STORYMAP_correct.drawio'));
        $this->assertEquals($this->story_map_analyzer->getFlows(), array(
            "T01. s'inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

    public function testFlowsWithIncorrectFile() {
        $this->story_map_analyzer->loadFileContent(file_get_contents('STORYMAP_faux.drawio'));
        $this->assertEquals($this->story_map_analyzer->getFlows(), array(
            "T01. s'inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

}
