<?php
namespace Autocomplete\Container\Trie;

use Autocomplete\Contract\Container\ContainerInterface;
use Autocomplete\Container\Trie\Node;

/**
 * @implements ContainerInterface
 */
class Trie implements ContainerInterface
{
    /**
     * @var Node
     */
    private $root;
    /**
     * @var boolean
     */
    private $caseSensitive = true;

    public function __construct($caseSensitive = true)
    {
        $this->root = new Node('');
        $this->caseSensitive = $caseSensitive;
    }

    private function inputParse(&$input)
    {
        if ( ! $this->caseSensitive) {
            $input = strtolower($input);
        }
    }

    public function addWord($word)
    {
        $this->inputParse($word);
        $this->root->addSuffix(str_split($word), $word);
    }

    public function hasPrefix($prefix)
    {
        $this->inputParse($prefix);
        $prefix = str_split($prefix);
        return $this->root->hasPrefix($prefix);
    }

    public function getByPrefix($prefix)
    {
        $this->inputParse($prefix);
        $child = $this->root->getClosest($prefix);
        if ( ! $child) {
            return [];
        }
        $postFixes = $child->getPostfix($prefix);
        return $postFixes;
    }

    public function hasWord($word)
    {
        $this->inputParse($word);
        $word = str_split($word);
        return $this->root->hasWord($word);
    }

    public function graph()
    {
        $graphArr = [];
        $this->root->graph($graphArr);
        return $graphArr;
    }
}
