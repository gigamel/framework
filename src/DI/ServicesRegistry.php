<?php

declare(strict_types=1);

namespace Slon\DI;

use InvalidArgumentException;
use Slon\ODR\MetaRegistry;

use function sprintf;

class ServicesRegistry extends MetaRegistry
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $services = [])
    {
        foreach ($services as $id => $service) {
            $this->addInstance($id, $service);
        }
    }
    
    /**
     * @throws InvalidArgumentException
     */
    protected function addInstance(string $id, object $service): void
    {
        if ($this === $service) {
            throw new InvalidArgumentException(sprintf(
                'Detected circular reference "%s"',
                $service::class,
            ));
        }
        
        if ($this->has($id)) {
            throw new InvalidArgumentException(sprintf(
                'Instance "%s" already exists',
                $id,
            ));
        }
        
        $this->instances[$id] = $service;
    }
}
