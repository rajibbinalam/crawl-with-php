<?php
# scraping books to scrape: https://books.toscrape.com/
require 'vendor/autoload.php';
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://books.toscrape.com/');
$htmlString = (string) $response->getBody();
//add this line to suppress any warnings
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);

$titles = $xpath->evaluate('//ol[@class="row"]//li//article//h3/a');
$prices = $xpath->evaluate('//ol[@class="row"]//li//article//div[@class="product_price"]//p[@class="price_color"]');
$images = $xpath->evaluate('//ol[@class="row"]//li//article//div[@class="image_container"]//a/img');

$extractedTitles = [];
foreach ($titles as $key => $title) {
    // $extractedTitles[] = $title->textContent . PHP_EOL;
    // echo $title->textContent . '<br/>';


    // echo $title->getAttribute('title') . PHP_EOL;
    // echo $prices[$key]->textContent.PHP_EOL;
    // echo $images[$key]->getAttribute('src') . PHP_EOL;

    echo '
        <div style="display:inline-block">
            <img src="https://books.toscrape.com/'.$images[$key]->getAttribute('src').'" style="padding: 5px 10px" />
            <h3>'.$title->getAttribute('title').'</h3>
            <h6>'.$prices[$key]->textContent.'</h6>
        </div>
        ';
}
