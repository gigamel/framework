<?php

declare(strict_types=1);

namespace Slon\DI;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

use function array_key_exists;
use function array_replace_recursive;
use function class_exists;
use function interface_exists;
use function is_string;

class Container implements ContainerInterface
{
    protected array $services = [];
    
    protected array $arguments = [];
    
    public function mergeArguments(array $arguments): array
    {
        $this->arguments = array_replace_recursive(
            $this->arguments,
            $arguments,
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function set(string $id, object|string|null $service = null): void
    {
        if (null === $service) {
            $service = $id;
        }
        
        if (!class_exists($service)) {
            throw new InvalidArgumentException(sprintf(
                'Unknown service "%s"',
                $service,
            ));
        }

        $this->services[$id] = $service ?? $id;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $id): object
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException(sprintf(
                'Unknown service [%s]',
                $id,
            ));
        }
        
        if (
            !is_string($this->services[$id])
            || !class_exists($this->services[$id])
        ) {
            return $this->services[$id];
        }
        
        $reflectionClass = new ReflectionClass($this->services[$id]);
        if (!$constructor = $reflectionClass->getConstructor()) {
            return $this->services[$id] = $reflectionClass->newInstance();
        }

        $this->checkMethodModifiers($constructor);
        
        $arguments = [];
        foreach ($constructor->getParameters() as $reflectionParameter) {
            $arguments[] = $this->getArgument($reflectionParameter, $id);
        }

        unset($this->arguments[$id]);
        return $this->services[$id] = $reflectionClass->newInstanceArgs(
            $arguments,
        );
    }
    
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
    
    /**
     * @throws InvalidArgumentException
     */
    public function newInstance(string $class, array $arguments = []): object
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf(
                'Failed instantiate object of type [%s]',
                $class,
            ));
        }
        
        $reflectionClass = new ReflectionClass($class);
        if (!$constructor = $reflectionClass->getConstructor()) {
            return $reflectionClass->newInstance();
        }

        $this->checkMethodModifiers($constructor);
        return $reflectionClass->newInstanceArgs($arguments);
    }
    
    protected function getArgument(
        ReflectionParameter $reflectionParameter,
        string $id,
    ): mixed {
        $type = $reflectionParameter->getType()->getName();
        if (
            class_exists($type)
            || interface_exists($type)
            && $this->has($type)
        ) {
            $argument = $this->get($type);
        } elseif (
            array_key_exists(
                $reflectionParameter->getName(),
                $this->arguments[$id] ?? []
            )
        ) {
            $argument = $this->arguments[$id][$reflectionParameter->getName()];
        } elseif ($reflectionParameter->isDefaultValueAvailable()) {
            $argument = $reflectionParameter->getDefaultValue();
        }

        return $argument ?? null;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function checkMethodModifiers(ReflectionMethod $reflectionMethod): void
    {
        if ($reflectionMethod->isPublic() && !$reflectionMethod->isAbstract()) {
            return;
        }

        throw new InvalidArgumentException(sprintf(
            'Method "%s:%s" must have public and not abstract modifiers',
            $reflectionMethod->getName(),
            $reflectionMethod->getDeclaringClass()->getName(),
        ));
    }
}
