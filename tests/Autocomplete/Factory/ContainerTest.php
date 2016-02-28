<?php
namespace Autocomplete\Factory;

class Containertest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->factory = new ContainerFactory;
    }

    public function testBuildingTrie()
    {
        $trie = $this->factory->build('Trie');
        $this->assertInstanceOf('Autocomplete\Container\Trie\Trie', $trie);
    }

    /**
     * @expectedException \Exception
     */
    public function testBuildingInvalidContainer()
    {
        $this->factory->build('InvalidContainer');
    }
}
