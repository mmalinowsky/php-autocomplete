<?php
namespace Autocomplete\Factory;

use Autocomplete\Contract\Container\ContainerInterface;

class ContainerFactory
{
    /**
     * @var string $namespace container namespace
     */
    private $namespace = '\Autocomplete\Container\\';

    /**
     * Build container
     *
     * @param string $name class name
     * @param array $args class arguments
     * @return ContainerInterface
     */
    public function build($name, $args = [])
    {
        $className = $this->namespace.$name.'\\'.$name;
        if ( ! class_exists($className)) {
            throw new \Exception('Class: '.$className.' not found.');
        }
        $container = new \ReflectionClass($className);
        $container = $container->newInstanceArgs($args);
        if ( ! $container instanceof ContainerInterface) {
            throw new \Exception('Bad container implementation');
        }
        return $container;
    }
}
