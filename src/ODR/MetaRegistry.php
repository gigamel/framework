<?php

declare(strict_types=1);

namespace Slon\ODR;

use InvalidArgumentException;
use RuntimeException;
use Slon\ODR\Exception\MetaInstanceNotFoundException;
use Slon\ODR\Meta\MetaInstanceInterface;
use Slon\ODR\Meta\MetaRegistryInterface;
use Slon\ODR\Meta\ReferenceInterface;

use function array_key_exists;
use function class_exists;
use function sprintf;

class MetaRegistry implements MetaRegistryInterface
{
    /** @var list<MetaInstanceInterface> */
    protected array $metaInstances = [];

    /** @var array<string, object> */
    protected array $instances = [];
    
    protected array $parameters = [];
    
    protected bool $isCompiled = false;

    /**
     * @throws InvalidArgumentException
     */
    public function addMeta(MetaInstanceInterface $metaInstance): void
    {
        if ($this->has($metaInstance->getId())) {
            throw new InvalidArgumentException(
                sprintf(
                    'Meta instance "%s" already exists',
                    $metaInstance->getId(),
                ),
            );
        }
        
        $this->metaInstances[$metaInstance->getId()] = $metaInstance;
    }

    /**
     * @throws MetaInstanceNotFoundException
     * @throws RuntimeException
     */
    public function get(string $id): object
    {
        if (array_key_exists($id, $this->instances)) {
            return $this->instances[$id];
        }

        foreach ($this->metaInstances as $metaInstance) {
            if ($id === $metaInstance->getId()) {
                return $this->instances[$id] = $this->instantiate(
                    $metaInstance,
                );
            }
        }

        throw new MetaInstanceNotFoundException(
            sprintf('Undefined "%s" instance', $id),
        );
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->instances)
            || array_key_exists($id, $this->metaInstances);
    }
    
    public function getParameter(string $name, mixed $default = null): mixed
    {
        return $this->parameters[$name] ?? $default;
    }
    
    public function setParameter(string $name, mixed $value): void
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @throws RuntimeException
     */
    protected function instantiate(MetaInstanceInterface $metaInstance): object
    {
        $arguments = [];
        foreach ($metaInstance->getArguments() as $name => $reference) {
            $this->checkCircular($metaInstance, $reference);
            $arguments[$name] = $reference->load($this);
        }

        return new ($metaInstance->getClassName())(...$arguments);
    }

    /**
     * @throws RuntimeException
     */
    protected function checkCircular(
        MetaInstanceInterface $rootMetaInstance,
        ReferenceInterface $innerReference,
        ?MetaInstanceInterface $innerMetaInstance = null,
    ): void {
        if (!class_exists($innerReference->getId())) {
            return;
        }

        if ($rootMetaInstance->getId() === $innerReference->getId()) {
            if ($innerMetaInstance) {
                throw new RuntimeException(
                    sprintf(
                        'Detected circular reference "%s" -> <- "%s"',
                        $rootMetaInstance->getClassName(),
                        $innerMetaInstance->getClassName(),
                    ),
                );
            } else {
                throw new RuntimeException(
                    sprintf(
                        'Detected self reference "%s"',
                        $rootMetaInstance->getClassName(),
                    ),
                );
            }
        }

        $nextMetaInstance = $this->metaInstances[$innerReference->getId()];
        foreach ($nextMetaInstance->getArguments() as $nextReference) {
            $this->checkCircular(
                $rootMetaInstance,
                $nextReference,
                $nextMetaInstance,
            );
        }
    }
    
    public function compile(): void
    {
        if ($this->isCompiled) {
            return;
        }
        
        foreach ($this->metaInstances as $metaInstance) {
            $this->instantiate($metaInstance);
        }
        
        $this->isCompiled = true;
    }
    
    public function getMetaInstances(): array
    {
        return $this->metaInstances;
    }
}
