<?php
/**
 * Class to analyze .bpmn file content
 * @author 
 */

class BPMNAnalyzer {
    /**
     * @var String
     */
    private $file_content;

    /**
     * Loads the whole file content in analyzer as a string without line breaks and indentation
     * @param array $file_content the .bpmn file content
     * @return self
     */
    public function loadFileContent(array $file_content) {
        foreach ($file_content as &$value) {
            $this->file_content .= trim($value);
        }
        return $this;
    }
    
    /**
     * Finds tag name
     * @param string $source the source code to process
     * @param int $index
     * @return string
     */
    public function extractNameTag($source, $index) {
        $name_tag = "";
        while ($source[$index]==" ") {
            $index += 1;
        }
        while ($source[$index]!=">" and $source[$index]!=" ") {
            $name_tag .= $source[$index];
            $index += 1;
        }
      	if ($index[0] < sizeof($source)-1) {
        	while ($source[$index]==">" or $source[$index]==" ") {
            	$index += 1;
            }
        }
        return $name_tag;
    }

    /**
     * Processes a tag
     * @param string $source the source code to process
     * @param int $index
     * @param array $tag A tag is represented by an array of 3 elements, of the form: $tag = array($name_tag, $child_tags, $text)
     * The first element of the array is a string specifying the name of the tag.
     * The second element of the array is the list of tags contained in the tag, also called child tags.
     * The third element in the array is the text contained in the tag.
     */
    public function analyze_tag($source, $index, $tag) {
        $text = "";
        while ($index < sizeof($source)) {
            $c = $source[$index];
            if ($c=="<") { // waiting for new tag or end of current tag's analysis
                if ($source[$index+1]=="/") { // tag's end
                    $index += 2;
                    $name_tag = extractNameTag($source, $index);
                    if ($name_tag!=$tag[0]) {
                        exit("Erreur de balise fermante");
                    }
                    else {
                        $tag[2] = $text;
                        return;
                    }
                }
                else {
                    $index += 1;
                    $name_tag = extractNameTag($source, $index);
                    $child_tag = array($name_tag, array(), "");
                    analyze_tag($source, $index, $child_tag);
                    array_push($tag[1], $child_tag);
                }
            }
            else {
                $text .= $c;
                $index += 1;
            }
        }
    }

    /**
     * Starts analysis of source code and detects first opening tag
     * @param string $source the source code to process
     * @return array list of tags
     */
    public function analyze($source) {
        $index = 0;
        while ($index < sizeof($source)) {
            $c = $source[$index];
            if ($c=="<") {
                $index += 1;
                $name_tag = extractNameTag($source, $index);
                $tag = array($name_tag, array(), "");
                analyze_tag($source, $index, $tag);
            }
            $index += 1;
        }
        return $tag;
    }

    /**
     * Optional, to be reviewed
     * Shows tree's content
     * @param array $tag
     * @param string $indent
     */
    public function show_tree($tag, $indent="") {
        $indent .= "\t";
        print "$indent<$tag[0]>";
        foreach ($tag[1] as $child_tag) {
            show_tree($child_tag, $indent);
        }
        if ($tag[2]!="") {
            print "$indent\t$tag[2]";
        }
        print "$indent</$tag[0]>";
    }

    public function parse() {
        print_r($this->file_content);
    }

}

?>