<?php
namespace Autocomplete\Container\Trie\Method;

class AddSuffix extends Template
{

    public function ifStringEnd()
    {
        $this->child->setEndNode($this->word);
        return true;
    }

    public function childIsInvalid(&$prevChild)
    {
        $child = $prevChild->addChild($this->char);
        return 
        [
            'return' => false,
            'returnValue' => $child
        ];
    }

}