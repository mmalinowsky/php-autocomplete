# php-autocomplete
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phaniso/php-autocomplete/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phaniso/php-autocomplete/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/phaniso/php-autocomplete/badge.svg?branch=master)](https://coveralls.io/github/phaniso/php-autocomplete?branch=master)
[![Build Status](https://travis-ci.org/phaniso/php-autocomplete.svg?branch=master)](https://travis-ci.org/phaniso/php-autocomplete)

Autocomplete PHP library that utilize trie data structure.



###Installation
```
composer require phaniso/autocomplete
```
###How to use
1. Build container
```
use Autocomplete\Factory\ContainerFactory;

$containerFactory = new ContainerFactory;
$trie = $containerFactory->build('Trie');
```

By default trie is case sensitive if you want to change it pass false as an argument
```
$trie = $containerFactory->build('Trie', [false]);
```

2.Add word
```
$trie->addWord('randomWord');
```
3.Get word(s) using prefix
```
$words = $trie->getByPrefix('random');
```
$words variable will now contain one element with 'randomWord' value
