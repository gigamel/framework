<?php

declare(strict_types=1);

namespace Slon\DI;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slon\DI\Exception\ServiceNotFoundException;
use Slon\ODR\Exception\MetaInstanceNotFoundException;
use Slon\ODR\Meta\MetaRegistryInterface;

use function sprintf;

class Container implements ContainerInterface
{
    public function __construct(
        protected MetaRegistryInterface $registry,
    ) {}
    
    /**
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): object
    {
        try {
            return $this->registry->get($id);
        } catch (MetaInstanceNotFoundException $e) {
            throw new ServiceNotFoundException(
                sprintf('Service "%s" not found', $id),
                previous: $e,
            );
        }
    }
    
    public function has(string $id): bool
    {
        return $this->registry->has($id);
    }
}
