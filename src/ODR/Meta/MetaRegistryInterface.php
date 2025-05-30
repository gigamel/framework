<?php

declare(strict_types=1);

namespace Slon\ODR\Meta;

use Slon\ODR\Exception\MetaInstanceNotFoundException;

interface MetaRegistryInterface
{
    public function addMeta(MetaInstanceInterface $metaInstance): void;

    /**
     * @throws MetaInstanceNotFoundException
     */
    public function get(string $id): object;

    public function has(string $id): bool;
    
    public function getParameter(string $name, mixed $default = null): mixed;
    
    public function setParameter(string $name, mixed $value): void;
    
    public function compile(): void;
    
    /**
     * @return array<string, MetaInstanceInterface>|list<MetaInstanceInterface>
     */
    public function getMetaInstances(): array;
}
