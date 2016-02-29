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
    private $children = [];
    /**
     * boolean|string
     */
    private $endNode;

    public function __construct($value)
    {
        $this->value = $value;
        $this->endNode = false;
    }

    public function getEndNode()
    {
        return $this->endNode;
    }

    public function setEndNode($value)
    {
        $this->endNode = $value;
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

    public function addSuffix($suffix)
    {
        $method = new Method\AddSuffix;
        return $method->execute($suffix, $this);
    }

    public function hasWord($word)
    {
        $method = new Method\HasWord;
        return $method->execute($word, $this);
    }

    public function hasPrefix($prefix)
    {
        $method = new Method\HasPrefix;
        return $method->execute($prefix, $this);
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
