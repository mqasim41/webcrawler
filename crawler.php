<?php


function getHtmlContent($url) {
    $htmlContent = file_get_contents($url);    
    return $htmlContent;
}


require 'C:\xampp\htdocs\vendor\autoload.php';

use Symfony\Component\BrowserKit\HttpBrowser;

function preprocessHtmlContent($url) {
    $httpClient = new HttpBrowser();

    try {
        
        $crawler = $httpClient->request('GET', $url);
        $title = $crawler->filter('title')->text();
        $links = $crawler->filter('a')->extract(['href']);
        // Filter out external links and non-article links
        $filteredLinks = array_filter($links, function ($link) {
            return strpos($link, 'wikipedia.org/wiki/') !== false;
        });
        $paragraphs = $crawler->filter('p')->each(function ($node) {
            return $node->text();
        });
        $result = [
            'url' => $url,
            'title' => $title,
            'paragraphs' => $paragraphs,
            'wikipediaLinks' => $filteredLinks
        ];
        return $result;

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function writeArrayToJsonFile(array $crawlingResults, string $filename) {

    $jsonContent = json_encode($crawlingResults, JSON_PRETTY_PRINT);
    file_put_contents($filename, $jsonContent);
    if (file_exists($filename)) {
        echo "Data has been written to '$filename' successfully." . PHP_EOL;
    } else {
        echo "Failed to write data to '$filename'." . PHP_EOL;
    }
}

// Example usage:
$urlToCrawl = 'https://www.wikipedia.org/';
$result = preprocessHtmlContent($urlToCrawl);

// Display the result
if (isset($result['error'])) {
    echo "Error: {$result['error']}\n";
} else {
    echo "Title: {$result['title']}\n";
    echo "Paragraphs:\n";
    foreach ($result['paragraphs'] as $paragraph) {
        echo "- $paragraph\n";
    }
    foreach ($result['wikipediaLinks'] as $link) {
        echo "- $link\n";
    }
}

writeArrayToJsonFile($result,"results.json");
?>