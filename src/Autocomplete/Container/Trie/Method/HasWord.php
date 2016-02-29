<?php
namespace Autocomplete\Container\Trie\Method;

class HasWord extends Template
{

    public function ifStringEnd()
    {
        return $this->child->getEndNode() ? true : false;
    }

    public function childIsInvalid(&$prevChild)
    {
        return 
        [
            'return' => true,
            'returnValue' => false
        ];
    }
}
