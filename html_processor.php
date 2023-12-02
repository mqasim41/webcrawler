<?php
namespace Qasim;
require 'C:\xampp\htdocs\vendor\autoload.php';


use Symfony\Component\BrowserKit\HttpBrowser;

class Preprocessor
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpBrowser();
    }


    public function preprocessHtmlContent($url)
    {
        try {
            $crawler = $this->httpClient->request('GET', $url);
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

    
}


