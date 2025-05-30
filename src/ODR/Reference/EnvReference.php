<?php

declare(strict_types=1);

namespace Slon\ODR\Reference;

use Slon\ODR\Meta\MetaRegistryInterface;
use Slon\ODR\Meta\ReferenceInterface;

class EnvReference implements ReferenceInterface
{
    public function __construct(protected string $name) {}

    public function getId(): string
    {
        return $this->name;
    }

    public function load(MetaRegistryInterface $registry): string|int|float|null
    {
        return $_ENV[$this->getId()] ?? null;
    }
}
