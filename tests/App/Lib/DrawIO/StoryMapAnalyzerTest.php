<?php

namespace Tests\App\Lib\DrawIO;

use App\Lib\DrawIO\StoryMapAnalyzer;
use PHPUnit\Framework\TestCase;

class StoryMapAnalyzerTest extends TestCase {

    private $story_map_analyzer;

    protected function setUp() : void {
        $this->story_map_analyzer = new StoryMapAnalyzer;
    }

    public function testFlowsWithCorrectFile() {
        $this->story_map_analyzer->loadFileContent(file_get_contents('tests/App/Lib/DrawIO/STORYMAP_correct.drawio'));
        $this->assertEquals($this->story_map_analyzer->getEpics(), array(
            "T01. s&#39;inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

    public function testFlowsWithIncorrectFile() {
        $this->story_map_analyzer->loadFileContent(file_get_contents('tests/App/Lib/DrawIO/STORYMAP_faux.drawio'));
        $this->assertNotEquals($this->story_map_analyzer->getEpics(), array(
            "T01. s&#39;inscrire", "T02. creer un projet", "T03. collaborer"
        ));
    }

}
