<?php
namespace Autocomplete\Container\Trie;

use Autocomplete\Container\Trie\Node;

class NodeTest extends \PHPUnit_Framework_TestCase
{

    public function testAddingWord()
    {
        $word = 'test';
        $trieNode = new Node('');
        $wordArr = str_split($word);
        $trieNode->addSuffix($wordArr);
        $children = $this->getChildrenProperty($trieNode);
        $hasWord = $trieNode->hasWord($wordArr);
        $this->assertSame(count($children), 1);
        $this->assertTrue($hasWord);
    }

    public function testAddingChild()
    {
        $value = 'c';
        $trieNode = new Node('');
        $trieNode->addChild($value);
        $children = $this->getChildrenProperty($trieNode);
        $valueRef = $this->setPropertyAccessible($children[0], 'value');
        $this->assertSame($valueRef->getValue($children[0]), $value);
    }

    public function testCheckingPrefix()
    {
        $word = 'test';
        $trieNode = new Node('');
        $wordArr = str_split($word);
        $trieNode->addSuffix($wordArr);
        $hasSuffix = $trieNode->hasPrefix(str_split(substr($word, 0, 3)));
        $this->assertTrue($hasSuffix);
    }

    private function getChildrenProperty(&$object)
    {
        $ref = $this->setPropertyAccessible($object, 'children');
        $children = $ref->getValue($object);
        return $children;
    }

    private function setPropertyAccessible(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }
}
