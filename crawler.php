<?php


function getHtmlContent($url) {
    $htmlContent = file_get_contents($url);    
    return $htmlContent;
}


require 'C:\xampp\htdocs\vendor\autoload.php';

use Goutte\Client;

function preprocessHtmlContent($url) {
    // Create a new Goutte client
    $client = new Client();

    try {
        // Send a GET request to the URL
        $crawler = $client->request('GET', $url);

        // Extract the title from the HTML
        $title = $crawler->filter('title')->text();

        // Extract all paragraph texts from the HTML
        $paragraphs = $crawler->filter('p')->each(function ($node) {
            return $node->text();
        });

        // Create an associative array with the extracted data
        $result = [
            'title' => $title,
            'paragraphs' => $paragraphs,
        ];

        return $result;
    } catch (\Exception $e) {
        // Handle exceptions (e.g., invalid URL, connection issues, etc.)
        return ['error' => $e->getMessage()];
    }
}

// Example usage:
$urlToCrawl = 'https://stackoverflow.com/questions/26224566/laravel-class-not-found-because-of-vendor-folder';
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
}
?>