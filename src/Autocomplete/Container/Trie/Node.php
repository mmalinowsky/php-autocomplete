<?php
namespace Autocomplete\Container\Trie;

use Autocomplete\Contract\Container\NodeInterface;

/**
 * @implements NodeInterface
 */
class Node implements NodeInterface
{
    /**
     * @var mixed
     */
    private $value;
    /**
     * @var Node
     */
    private $children;
    /**
     * boolean|string
     */
    private $endNode;

    public function __construct($value)
    {
        $this->value = $value;
        $this->children = [];
        $this->endNode = false;
    }

    public function getChild($string)
    {
        foreach ($this->children as $child) {
            if ($child->value == $string) {
                return $child;
            }
        }
        return false;
    }

    public function getClosest($prefix)
    {
        $child = $this;
        $prefix = str_split($prefix);
        foreach ($prefix as $char) {
            if ($child) {
                $child = $child->getChild($char);
            }
        }
        return $child;
    }

    public function getPostfix($prefix, $postFixes = [])
    {
        if ($this->endNode) {
            $postFixes[] = $this->endNode;
        }
        foreach ($this->children as $child) {
            $postFixes = $child->getPostfix($prefix, $postFixes);
        }
        return $postFixes;
    }

    public function addChild($name)
    {
        if ($this->getChild($name)) {
            return $this->getChild($name);
        }
        $child = new Node($name);
        $this->children[] = $child;
        return $child;
    }

    public function addSuffix($suffix, $word)
    {
         if (count($suffix) < 1) {
            $this->endNode = $word;
            return true;
        }
        $char = array_shift($suffix);
        $child = $this->getChild($char);
        if ( ! $child) {
            $child = $this->addChild($char);
        }
        $child->addSuffix($suffix, $word);
    }

    public function hasWord($word)
    {
        if (count($word) < 1) {
            return $this->endNode ? true : false;
        }
        $char = array_shift($word);
        $child = $this->getChild($char);
        if ( ! $child) {
            return false;
        }
        return $child->hasWord($word);
    }

    public function hasPrefix($prefix)
    {
        if (count($prefix) < 1) {
            return true;
        }
        $char = array_shift($prefix);
        $child = $this->getChild($char);
        if ( ! $child) {
            return false;
        }
        return $child->hasPrefix($prefix);
    }

    public function graph(array &$arr, $level = 0)
    {
        $arr[$level][] = $this->value;
        $level++;
        foreach ($this->children as $child) {
            $child->graph($arr, $level);
        }
    }
}
