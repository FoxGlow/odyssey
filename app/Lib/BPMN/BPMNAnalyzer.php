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

    public $index; //needs to be changed to private later

    /**
     * Loads the whole file content in analyzer as a string
     * @param string $file_content the .bpmn file content
     * @return self
     */
    public function loadFileContent(string $file_content) {
        $this->file_content = $file_content;
        $this->index = 0;
        return $this;
    }
    
    /**
     * Finds tag name
     * @return string the tag name
     */
    private function extractTagName() {
        $tag_name = "";
        while ($this->file_content[$this->index] != ">" && $this->file_content[$this->index] != " ") {
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
     * Processes a tag
     * @param array $tag A tag is represented by an array of 3 elements, of the form: $tag = array($tag_name, $child_tags, $text)
     * The first element of the array is a string specifying the name of the tag.
     * The second element of the array is the list of tags contained in the tag, also called child tags.
     * The third element in the array is the text contained in the tag.
     */
    private function analyzeTag(array &$tag) {
        $text = "";
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
                        $tag[2] = $text;//array_push($tag[2], $text);
                        return;
                    }
                }
                else { //start of tag
                    $this->index++;
                    $tag_name = $this->extractTagName();
                    $child_tag = array($tag_name, array(), "");
                    $this->analyzeTag($child_tag);
                    array_push($tag[1], $child_tag);//$tag[1] = $child_tag;//
                }
            }
            else {
                $text .= $c;
                $this->index++;
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
                $tags = array($tag_name, array(), "");
                $this->analyzeTag($tags);
            }
            $this->index++;
        }
        return $tags;
    }

    /**
     * Optional, to be reviewed
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

?>