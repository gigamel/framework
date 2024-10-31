<?php declare(strict_types=1);

namespace Gigamel\DI;

interface ContainerInterface
{
    public function importArguments(string $source): void;
    
    /**
     * @throws ContainerException
     */
    public function set(string $id, mixed $dependency = null): void;

    /**
     * @throws ContainerException
     */
    public function get(string $id): mixed;
    
    public function has(string $id): bool;
    
    /**
     * @throws ContainerException
     */
    public function newInstance(string $class, array $arguments = []): object;
}
