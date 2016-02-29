<?php
namespace Autocomplete\Container\Trie\Method;

abstract class Template
{

    public $char;
    public $child;
    public $word;

    final public function execute($string, &$child)
    {
       $this->word = (join($string));
       $this->child = $child;
       return $this->algorithm($string, $child);
    }

    final public function algorithm($string)
    {
        if (count($string) < 1) {
            return $this->ifStringEnd();
        }
        $this->char = array_shift($string);
        $prevChild = $this->child;
        $this->child = $this->child->getChild($this->char);
        if ( ! $this->child) {
            $ret = $this->childIsInvalid($prevChild);
            $this->child = $ret['returnValue'];
            if ($ret['return']) {
                return $ret['returnValue'];
            }
        }
        return $this->algorithm($string);
    }

    abstract public function ifStringEnd();
    abstract public function childIsInvalid(&$prevChild);
}
