<?php
/**
 * Class to analyze .bpmn file content
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

class BPMNAnalyzer {
    /**
     * @var String
     */
    public $file_content; //needs to be changed to private later

    /**
     * @var Int
     */
    public $index; //needs to be changed to private later

    /**
     * Loads the whole file content in analyzer as a string without line breaks and indentation
     * @param string $file_content the .bpmn file content
     * @return self
     */
    public function loadFileContent(string $file_content) {
        $this->file_content = $file_content;
        $this->index = 1;
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
        }
    }
  
    /*
     * Finds tag name
     * @param int $index
     * @return string the tag name
     */
    private function extractTagName(int $index) {
        $tag_name = "";
        while ($this->file_content[$index] != ">" && $this->file_content[$index] != " ") {
            $tag_name .= $this->file_content[$index];
            $index++;
        }
      	if ($index[0] < sizeof($this->file_content)-1) {
        	while ($this->file_content[$index] == ">" || $this->file_content[$index] == " ") {
            	$index++;
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
        $attribute[1] = $value;
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
    public function analyze() {
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
     * Optional, to be reviewed or deleted
     * Shows tree's content
     * @param array $tag
     * @param string $indent
     */
    public function showTree(array $tags, string $indent = "") {
        $indent .= "\t";
        print "$indent<$tags[0]>";
        foreach ($tags[1] as $child_tag) {
            $this->showTree($child_tag, $indent);
        }
        if ($tags[2]!="") {
            print "$indent\t$tags[2]";
        }
        print "$indent</$tags[0]>";
    }

}
