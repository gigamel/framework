<?php

declare(strict_types=1);

namespace Gigamel\Argument;

use InvalidArgumentException;

interface ConstructorParserInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function getArguments(string $class): array;
}
