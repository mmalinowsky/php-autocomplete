<?php
namespace Autocomplete\Contract\Container;

interface ContainerInterface
{
    /**
     * Add word
     *
     * @param string $word
     */
    public function addWord($word);
    /**
     * Has prefix
     *
     * @param string $prefix
     */
    public function hasPrefix($prefix);
    /**
     * Get words using prefix
     *
     * @param string $prefix
     * @return array
     */
    public function getByPrefix($prefix);
    /**
     * Check if container has word
     *
     * @param string $word
     * @param boolean
     */
    public function hasWord($word);
}
