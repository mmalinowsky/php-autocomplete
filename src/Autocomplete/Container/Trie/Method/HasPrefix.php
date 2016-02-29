<?php
namespace Autocomplete\Container\Trie\Method;

class hasPrefix extends Template
{

    public function ifStringEnd()
    {
        return true;
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
