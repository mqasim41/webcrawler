<?php

require 'C:\xampp\htdocs\vendor\autoload.php';
require 'C:\xampp\htdocs\webcrawler\html_processor.php';
require 'C:\xampp\htdocs\webcrawler\search.php';
use Qasim\Preprocessor;
use Qasim\Search;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $searchString = $_POST["searchString"];
    $maxDepth = $_POST["maxDepth"];
    $seedUrl = $_POST["seedUrl"];
}
function writeArrayToJsonFile(array $crawlingResults, string $filename)
{   
    
    if (file_exists($filename)) {
        $existingContent = file_get_contents($filename);
        $existingData = json_decode($existingContent, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $mergedData = array_merge_recursive($existingData, $crawlingResults);
            
            $jsonContent = json_encode($mergedData, JSON_PRETTY_PRINT);
        } else {
            echo "Failed to decode existing JSON content." . PHP_EOL;
            return;
        }
    } else {
        $jsonContent = json_encode($crawlingResults, JSON_PRETTY_PRINT);
    }

    file_put_contents($filename, $jsonContent);
    if (file_exists($filename)) {
        
    } else {
        echo "Failed to write data to '$filename'." . PHP_EOL;
    }
}

function crawlUrlsUpToDepth($depthLimit, $url, $searchString)
    {
        $outputFilename = 'results.json';
        if(file_exists($outputFilename)){
            unlink($outputFilename);
        }

        $preprocessor = new Preprocessor();
        $urlQueue = new SplQueue();
        $urlQueue->enqueue([$url, 0]); // [URL, currentDepth]
        $results = [];

        while (!$urlQueue->isEmpty()) {
            [$currentUrl, $currentDepth] = $urlQueue->dequeue();

            $result = $preprocessor->preprocessHtmlContent($currentUrl);
            $search = new Search($result);
            $searchResults = $search->searchInContent($searchString);
            if($searchResults != -1){
                writeArrayToJsonFile($searchResults, $outputFilename);
            }
            
            
            

            if ($currentDepth < $depthLimit) {
                $newUrls = $result['wikipediaLinks'];
                foreach ($newUrls as $newUrl) {
                    $urlQueue->enqueue([$newUrl, $currentDepth + 1]);
                }
            }
        }
        if(!file_exists($outputFilename)){
            writeArrayToJsonFile([], $outputFilename);
        }

        return $results;
    }
crawlUrlsUpToDepth($maxDepth,$seedUrl,$searchString);


?>