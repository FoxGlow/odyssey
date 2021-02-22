<?php
/**
 * Class to analyze .bpmn file content
 * @author Simon Boutrouille, Amaury Denis, Kamelia Brahimi, Thileli Saci, Zineb Brahimi
 */

class BPMNAnalyzer {
    /**
     * @var String
     */
    private $file_content;

    /**
     * Loads the whole file content in analyzer as a string without line breaks and indentation
     * @param string $file_content the .bpmn file content
     * @return self
     */
    public function loadFileContent(string $file_content) {
        $this->file_content = $file_content;
        return $this;
    }
    
    /**
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
        }
        return trim($tag_name);
    }

    /**
     * Processes a tag
     * @param int $index
     * @param array $tag A tag is represented by an array of 3 elements, of the form: $tag = array($tag_name, $child_tags, $text)
     * The first element of the array is a string specifying the name of the tag.
     * The second element of the array is the list of tags contained in the tag, also called child tags.
     * The third element in the array is the text contained in the tag.
     */
    private function analyzeTag(int $index, array $tag) {
        $text = "";
        while ($index < sizeof($this->file_content)) {
            $c = $this->file_content[$index];
            if ($c == "<") { // waiting for new tag or end of current tag's analysis
                if ($this->file_content[$index + 1] == "/") { // tag's end
                    $index += 2;
                    $tag_name = $this->extractTagName($index);
                    if ($tag_name != $tag[0]) {
                        exit("Erreur de balise fermante");
                    }
                    else {
                        $tag[2] = $text;
                        return;
                    }
                }
                else {
                    $index++;
                    $tag_name = $this->extractTagName($index);
                    $child_tag = array($tag_name, array(), "");
                    $this->analyzeTag($index, $child_tag);
                    array_push($tag[1], $child_tag);
                }
            }
            else {
                $text .= $c;
                $index++;
            }
        }
    }

    /**
     * Starts analysis of source code and detects first opening tag
     * @return array list of tags
     */
    public function analyze() {
        $index = 0;
        while ($index < sizeof($this->file_content)) {
            $c = $this->file_content[$index];
            if ($c == "<") {
                $index++;
                $tag_name = $this->extractTagName($this->file_content, $index);
                $tags = array($tag_name, array(), "");
                $this->analyzeTag($index, $tags);
            }
            $index++;
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