<?php

declare(strict_types=1);

namespace Slon\ODR;

use InvalidArgumentException;
use Slon\ODR\Meta\MetaRegistryInterface;
use Slon\ODR\Meta\ReferenceInterface;

use function sprintf;

class Reference implements ReferenceInterface
{
    protected string $id;

    public function __construct(string $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException(sprintf(
                'Reference id "%s" is empty',
                $id,
            ));
        }

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function load(MetaRegistryInterface $registry): object
    {
        return $registry->get($this->id);
    }
}
