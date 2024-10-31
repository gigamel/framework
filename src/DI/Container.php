<?php declare(strict_types=1);

namespace Gigamel\DI;

use Gigamel\DI\Argument\ImporterInterface;
use Gigamel\DI\Argument\PhpArrayImporter;
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
    protected array $dependencies = [];
    
    protected array $arguments = [];
    
    protected ImporterInterface $importer;
    
    public function __construct(?ImporterInterface $importer = null)
    {
        $this->importer = $importer ?? new PhpArrayImporter();
    }
    
    public function importArguments(string $source): void
    {
        $arguments = $this->importer->import($source);
        if ($arguments) {
            $this->arguments = array_replace_recursive($this->arguments, $arguments);
        }
    }

    /**
     * @throws ContainerException
     */
    public function set(string $id, mixed $dependency = null): void
    {
        if ($this->has($id)) {
            throw new ContainerException(sprintf(
                'Dependency [%s] already exists',
                $id
            ));
        }

        if (null === $dependency && !class_exists($id)) {
            throw new ContainerException(
                'ID should be type of class when Dependency NULL',
            );
        }

        $this->dependencies[$id] = $dependency ?? $id;
    }

    /**
     * @throws ContainerException
     */
    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new ContainerException(sprintf(
                'Unknown dependency [%s]',
                $id
            ));
        }
        
        if (!is_string($this->dependencies[$id]) || !class_exists($this->dependencies[$id])) {
            return $this->dependencies[$id];
        }
        
        $reflectionClass = new ReflectionClass($this->dependencies[$id]);
        if (!$constructor = $reflectionClass->getConstructor()) {
            return $this->dependencies[$id] = $reflectionClass->newInstance();
        }

        $this->checkMethodModifiers($constructor);
        
        $arguments = [];
        foreach ($constructor->getParameters() as $reflectionParameter) {
            $arguments[] = $this->getArgument($reflectionParameter, $id);
        }

        unset($this->arguments[$id]);
        return $this->dependencies[$id] = $reflectionClass->newInstanceArgs($arguments);
    }
    
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->dependencies);
    }
    
    /**
     * @throws ContainerException
     */
    public function newInstance(string $class, array $arguments = []): object
    {
        if (!class_exists($class)) {
            throw new ContainerException(sprintf(
                'Failed instantiate object of type [%s]',
                $class
            ));
        }
        
        $reflectionClass = new ReflectionClass($class);
        if (!$constructor = $reflectionClass->getConstructor()) {
            return $reflectionClass->newInstance();
        }

        $this->checkMethodModifiers($constructor);
        return $reflectionClass->newInstanceArgs($arguments);
    }
    
    protected function getArgument(ReflectionParameter $reflectionParameter, string $id): mixed
    {
        $type = $reflectionParameter->getType()->getName();
        if (class_exists($type) || interface_exists($type) && $this->has($type)) {
            $argument = $this->get($type);
        } elseif (array_key_exists($reflectionParameter->getName(), $this->arguments[$id] ?? [])) {
            $argument = $this->arguments[$id][$reflectionParameter->getName()];
        } elseif ($reflectionParameter->isDefaultValueAvailable()) {
            $argument = $reflectionParameter->getDefaultValue();
        }
        return $argument ?? null;
    }

    /**
     * @throws ContainerException
     */
    protected function checkMethodModifiers(ReflectionMethod $reflectionMethod): void
    {
        if ($reflectionMethod->isPublic() && !$reflectionMethod->isAbstract()) {
            return;
        }

        throw new ContainerException(sprintf(
            'Method [%s] of class [%s] must has public and not abstract modifiers.',
            $reflectionMethod->getName(),
            $reflectionMethod->getDeclaringClass()->getName()
        ));
    }
}
