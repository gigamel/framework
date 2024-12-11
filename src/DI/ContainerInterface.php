<?php

declare(strict_types=1);

namespace Gigamel\DI;

use InvalidArgumentException;

interface ContainerInterface
{
    public function importArguments(string $file): void;
    
    /**
     * @throws InvalidArgumentException
     */
    public function set(string $id, mixed $dependency = null): void;

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $id): mixed;
    
    public function has(string $id): bool;
    
    /**
     * @throws InvalidArgumentException
     */
    public function newInstance(string $class, array $arguments = []): object;
}
