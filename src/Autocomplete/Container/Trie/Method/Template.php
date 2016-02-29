<?php
namespace Autocomplete\Container\Trie\Method;

abstract class Template
{

    public $char;
    public $child;
    public $word;

    public final function execute($string, &$child)
    {
       $this->word = (join($string));
       $this->child = $child;
       return $this->algorithm($string, $child);
    }

    public final function algorithm($string)
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
        return $this->algorithm($string, $this->child);
    }

    abstract public function ifStringEnd();
    abstract public function childIsInvalid(&$prevChild);
}