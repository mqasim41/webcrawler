<?php
namespace Qasim;
require 'C:\xampp\htdocs\vendor\autoload.php';

class Search {
    private $preprocessedContent;
    public function __construct($preprocessedContent)
    {
        $copiedContent = $preprocessedContent;
        $this->preprocessedContent = $copiedContent;
    }
    public function searchInContent($searchString) {
        $matchedContent = [];
    
        for ($i = 0; $i < min(50, count($this->preprocessedContent['paragraphs'])); $i++) {
            // Remove non-alphanumeric characters and extra whitespaces
            $cleanedParagraph = preg_replace('/[^\p{L}\p{N}\s]/u', '', $this->preprocessedContent['paragraphs'][$i]);
        
            // Check if the cleaned paragraph contains the search string
            if (
                
                stripos($cleanedParagraph, $searchString) !== false &&
                $cleanedParagraph !== "" &&
                mb_check_encoding($cleanedParagraph, 'ASCII') 
            ) {
                $matchedContent[] = $cleanedParagraph;
            }
        }
    
        if (!empty($matchedContent)) {
            $result[] = [
                'url' => $this->preprocessedContent['url'],
                'title' => $this->preprocessedContent['title'],
                'matchedContents' => $matchedContent
            ];
        } else {
            $result = -1;
        }
    
        return $result;
    }

}