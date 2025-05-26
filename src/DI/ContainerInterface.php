<?php

declare(strict_types=1);

namespace Slon\DI;

use InvalidArgumentException;

interface ContainerInterface
{
    public function mergeArguments(array $arguments): void;
    
    /**
     * @throws InvalidArgumentException
     */
    public function set(string $id, object|string|null $service = null): void;

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $id): object;
    
    public function has(string $id): bool;
    
    /**
     * @throws InvalidArgumentException
     */
    public function newInstance(string $class, array $arguments = []): object;
}
