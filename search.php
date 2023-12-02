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
    public function searchInContent($searchString){
    $matchedContent = [];

    foreach ($this->preprocessedContent['paragraphs'] as $paragraph) {
        if (stripos($paragraph, $searchString) !== false) {
            $matchedContent[] = $paragraph;
        }
    }
    if($matchedContent != []){
        $result[$this->preprocessedContent['url']] = ['title'=>$this->preprocessedContent['title'],'matchedContents'=>$matchedContent];
    }
    else{
        $result[$this->preprocessedContent['url']] = ["No Result"];
    }
    return $result;
    }

}