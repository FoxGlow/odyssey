<?php

/**
 * Class to analyze .drawio file content
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

class StoryMapAnalyzer
{
    /**
     * @var String
     */
    public $file_content;

    /**
     * Loads file content in analyzer
     * @param $file_content the .drawio file content
     * @return self
     */
    public function loadFileContent(string $file_content)
    {
        $this->file_content = $file_content;
        return $this;
    }

    public function parse()
    {
        print_r($this->file_content);
    }

    /**
     * @return a list of all the epics
     */
    public function analyzeSTORYMAP()
    {

        $elements = explode(" ", $this->file_content);
        $values = array();
        $pattern = 'fillColor=#f8cecc';
        for ($i = 0; $i < count($elements); $i++) {
            if (str_contains($elements[$i], $pattern)) {
                array_push($values, $elements[$i - 1]);
            }
        }
        return $values;
    }
}
