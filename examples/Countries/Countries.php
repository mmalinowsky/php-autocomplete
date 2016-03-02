<?php
header('Content-Type: application/json');

use Autocomplete\Factory\ContainerFactory;

require_once(__DIR__.'/../bootstrap.php');

$containerFactory = new ContainerFactory;
$trie = $containerFactory->build('Trie', [false]);

function loadWords(&$trie) {
    $file = new SplFileObject(__DIR__."/countries.txt");
    while ( ! $file->eof()) {
        $country = trim($file->fgets());
        $country = explode("|", $country)[1];
        $trie->addWord($country);
    }
}

loadWords($trie);
$key = isset($_GET['key']) ? $_GET['key'] : '';
$countryInput = $key;
$countries = $trie->getByPrefix($countryInput);

echo json_encode($countries);