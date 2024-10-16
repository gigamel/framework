<?php declare(strict_types=1);

namespace Gigamel\DI;

interface ContainerInterface
{
    public function importArguments(string $source): void;
    
    /**
     * @throws Exception
     */
    public function put(string $id, mixed $dependency = null): void;

    /**
     * @throws Exception
     */
    public function get(string $id): mixed;
    
    public function has(string $id): bool;
    
    /**
     * @throws Exception
     */
    public function newInstance(string $class, array $arguments = []): object;
}
