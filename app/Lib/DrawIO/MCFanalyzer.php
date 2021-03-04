<?php

/**
 * Class to analyze .drawio file content (MCF)
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

namespace App\Lib\DrawIO;

class MCFAnalyzer
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

    /**
     * Starts analysis of MCF loaded file
     * @return array a list of all the flows
     */
    public function analyze()
    {
        $elements = explode(" ", $this->file_content);
        $flow = "";
        $values = array();
        $flows = array();
        $pattern = 'style="edgeLabel';
        $pattern2 = 'value="';

        for ($i = 0; $i < count($elements); $i++) {
            // Check if the element starts with 'value="' and extract its index
            if (str_starts_with($elements[$i], $pattern2)) {
                $index = $i;
            }
            // Check if the element starts with 'style="edgeLabel"', extract all the elements between 'value' and 'style' and put them in a list of sub-lists
            if (str_starts_with($elements[$i], $pattern)) {
                $words = array_slice($elements, $index, $i - $index, false);
                array_push($values, $words);
            }
        }
        // Concatenate the elements of each sub-list and put them in a final list of flows 
        foreach ($values as $value) {
            $flow = $value[0];
            for ($j = 1; $j < count($value); $j++) {
                $flow = $flow . " " . $value[$j];
            }
            array_push($flows,rtrim(ltrim($flow, "value=\""),"\""));
        }
        return $flows;
    }
}
