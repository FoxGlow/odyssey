<?php
/**
 * Class to analyze .bpmn file content
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

namespace App\Lib\BPMNIO;

class BPMNAnalyzer {
    /**
     * @var String
     */
    private $file_content;

    /**
     * @var Int
     */
    private $index;

    /**
     * @var Array
     */
    private $result;

    /**
     * File content getter function
     * @return string the file content
     */
    public function getFileContent() {
        return $this->file_content;
    }
	
    /**
     * Index getter function
     * @return int the index
     */
    public function getIndex() {
        return $this->index;
    }
	
    /**
     * Result getter function
     * @return array the result is an array of the form [[activities], [flows]]
     * The first element of the array is a list of strings representing the activities
     * The second element of the array is a list of strings representing the flows
     */
    public function getResult(){
        return $this->result;
    }

    /**
     * Loads the whole file content in analyzer as a string
     * @param string $file_content the .bpmn file content
     * @return self
     */
    public function loadFileContent(string $file_content) {
        $this->file_content = $file_content;
        $this->index = 1;
        $this->result = array("Activités" => array(), "Flux" => array());
        return $this;
    }
    
    /**
     * Extracts tag's name
     * @return string the tag name
     */
    private function extractTagName() {
        $tag_name = "";
        while ($this->file_content[$this->index] != ">" && $this->file_content[$this->index] != " " && $this->file_content[$this->index] != "/") {
            $tag_name .= $this->file_content[$this->index];
            $this->index++;
        }
      	if ($this->index < (strlen($this->file_content)-1)) {
        	while ($this->file_content[$this->index] == ">" || $this->file_content[$this->index] == " ") {
            	$this->index++;
            }
        }
        return trim($tag_name);
    }

    /**
     * Extracts one attribute
     * @return array An attribute is represented by an array of 2 strings, of the form: [name, value]
     */
    private function extractAttribute() {
        $attribute = array("","");
        $name = "";
        $value = "";
        $equals = false;
        $closing = 0;
        while ($this->file_content[$this->index] != ">" && $closing < 2) {
            if ($this->file_content[$this->index] == "=") {
                $equals = true;
                $this->index++;
            }
            if ($this->file_content[$this->index] == "\"") {
                $closing+=1;
                $this->index++;
            }
            if ($equals == true) {
                $value .= $this->file_content[$this->index];
                $this->index++;
            }
            else {
                $name .= $this->file_content[$this->index];
                $this->index++;
            }
        }
        if ($this->index < (strlen($this->file_content)-1)) {
        	while ($this->file_content[$this->index] == ">" || $this->file_content[$this->index] == " ") {
            	$this->index++;
            }            
        }
        $attribute[0] = $name;
        $attribute[1] = rtrim($value, ">");
        return $attribute;
    }

    /**
     * Extracts tag's text
     * @return string the text
     */
    private function extractText() {
        $text = "";
        while ($this->file_content[$this->index] != "<") {
            $text .= $this->file_content[$this->index];
            $this->index++;
        }
        return $text;
    }

    /**
     * Processes a tag
     * @param array $tag A tag is represented by an array of 4 elements, of the form:  [tag_name, child_tags, text, attributes]
     * The first element of the array is a string specifying the name of the tag.
     * The second element of the array is the list of tags contained in the tag, also called child tags.
     * The third element in the array is a string specifying the text contained in the tag.
     * The fourth element in the array is the list of attribute(s)
     */
    private function analyzeTag(array &$tag) {
        while ($this->index < strlen($this->file_content)) {
            $c = $this->file_content[$this->index];
            if ($c == "<") { // waiting for new tag or end of current tag's analysis
                if ($this->file_content[$this->index + 1] == "/") { // tag's end
                    $this->index += 2;
                    $tag_name = $this->extractTagName();
                    if ($tag_name != $tag[0]) {
                        exit("Erreur de balise fermante");
                    }
                    else {
                        return;
                    }
                }
                else { //start of tag
                    $this->index++;
                    $tag_name = $this->extractTagName();
                    $child_tag = array($tag_name, array(), "", array());
                    $this->analyzeTag($child_tag);
                    array_push($tag[1], $child_tag);
                }
            }
            elseif ($c == "/" && $this->file_content[$this->index + 1] == ">") { //end of self closing tag
                $this->index += 2;
                return;
            }
            else { //tag's attributes
                if ($this->file_content[$this->index - 1] == " ") {
                    $attribute = $this->extractAttribute();
                    array_push($tag[3], $attribute);
                } //tag's text
                elseif ($this->file_content[$this->index - 1] == ">") {
                    $text = $this->extractText();
                    $tag[2] = $text;
                }
            }
        }
    }

    /**
     * Starts analysis of source code and detects first opening tag
     * @return array list of tags
     */
    private function analyze() {
        while ($this->index < strlen($this->file_content)) {
            $c = $this->file_content[$this->index];
            if ($c == "<") {
                $this->index++;
                $tag_name = $this->extractTagName();
                $tags = array($tag_name, array(), "", array());
                $this->analyzeTag($tags);
            }
            $this->index++;
        }
        return $tags;
    }

    /**
     * Retrieves tag's activity or flow name
     * @param array $tags result of analyze function
     */
    private function iterateThrough($tags) {
        $tasks = array("bpmn:task", "bpmn:sendTask", "bpmn:receiveTask", "bpmn:userTask", "bpmn:manualTask", "bpmn:businessRuleTask", "bpmn:serviceTask", "bpmn:scriptTask", "bpmn:callActivity", "bpmn:subProcess");
        if (in_array($tags[0], $tasks)) {
            foreach ($tags[3] as $attribute) {
                if ($attribute[0] == "name") {
                    array_push($this->result["activities"], $attribute[1]);
                }
            }
        }

        if ($tags[0] == "bpmn:messageFlow") {
            foreach ($tags[3] as $attribute) {
                if ($attribute[0] == "name") {
                    array_push($this->result["flows"], $attribute[1]);
                }
            }
        }

        foreach ($tags[1] as $child) {
            $this->iterateThrough($child);
        }
    }

    /**
     * Gets the flows
     * @return array the list of flows
     */
    public function getFlows() : array {
        return $this->iterateThrough($this->analyze())['flows'];
    }

    /**
     * Gets the activities
     * @return array the list of activities
     */
    public function getActivities() : array {
        return $this->iterateThrough($this->analyze())['activities'];
    }

}
