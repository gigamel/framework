<?php

declare(strict_types=1);

namespace Slon\ODR;

use Slon\ODR\Meta\MetaInstanceInterface;
use Slon\ODR\Meta\ReferenceInterface;
use InvalidArgumentException;

use function array_key_exists;
use function class_exists;
use function sprintf;

class MetaInstance implements MetaInstanceInterface
{
    /** @var array<string, ReferenceInterface> */
    protected array $arguments = [];

    protected string $className;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $className,
        protected ?string $id = null
    ) {
        if (!class_exists($className)) {
            throw new InvalidArgumentException(sprintf(
                'Class "%s" does not exists',
                $className,
            ));
        }
        
        $this->className = $className;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addArgument(
        string $name,
        ReferenceInterface $reference,
    ): self {
        if (empty($name)) {
            throw new InvalidArgumentException(sprintf(
                'Argument name of class "%s" must not be empty',
                $this->getClassName(),
            ));
        }

        if (array_key_exists($name, $this->arguments)) {
            throw new InvalidArgumentException(sprintf(
                'Argument "%s" already exists',
                $name,
            ));
        }

        $this->arguments[$name] = $reference;
        return $this;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getClassName(): string
    {
        return $this->className;
    }
    
    public function getId(): string
    {
        return $this->id ?? $this->className;
    }
}
