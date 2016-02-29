<?php

use Autocomplete\Factory\ContainerFactory;

require_once(__DIR__.'/../bootstrap.php');

$running = true;
$containerFactory = new ContainerFactory;
$trie = $containerFactory->build('Trie', [false]);

function loadWords(&$trie) {
    $file = new SplFileObject(__DIR__."/dictionary.txt");
    while ( ! $file->eof()) {
        $trie->addWord(trim($file->fgets()));
    }
    echo "Words Loaded.\n";
}

loadWords($trie);

while ($running) {
    $input = fgets(STDIN, 1024);
    $input = trim($input);
    parseInput($input, $trie);
    if($input == 'quit') $running = false;
}

function parseInput($input, $trie)
{
    if ($trie->hasWord($input)) {
        echo "Word {$input} found.\n";
        return;
    }
    $lookup = lookup($input, $trie);
    if ($lookup) {
        echo "Huh, invalid word did you mean {$lookup}?\n";
        return;
    }
    echo "Prefix not found.\n";
}

function lookup($word, $trie, $minLen = 3, $minSearch = 2)
{
    $wordLen = strlen($word);
    if ($wordLen < $minLen) {
        return false;
    }
    for ($i=$wordLen; $i > $minSearch; $i--) {
        $wordPreffix = substr($word,0 , $i);
        $words = $trie->getByPrefix($wordPreffix);
        //return first element of $words array
        return reset($words);
    }
    return false;
}
