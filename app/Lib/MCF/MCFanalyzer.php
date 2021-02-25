<?php
/**
 * Class to analyze .drawio file content
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

class MCFanalyzer {
    /**
     * @var string
     */
    public $file_content;

    /**
     * Loads file content in analyzer
     * @param $file_content the .drawio file content
     * @return self
     */
    public function loadFileContent(string $file_content) {
        $this->file_content = $file_content;
        return $this;
    }
    
    public function parse() {
        print_r($this->file_content);
    }

    /**
     * @return array list of all the flows
     */
    public function analyzeMCF() {
        $elements = explode(" ", $this->file_content); 
        $values = array();
        $pattern = 'style="edgeLabel';
        for ($i=0; $i<count($elements) ; $i++) {
            /*if(preg_match($pattern,$elements[$i]))*/
            if (str_starts_with($elements[$i], $pattern)) {
            array_push($values,$elements[$i - 1]);
            }
            else {
                echo "this is not a flow" ;
            }
        }
            return $values;
    }
}
