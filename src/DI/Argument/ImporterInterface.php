<?php declare(strict_types=1);

namespace Gigamel\DI\Argument;

interface ImporterInterface
{
    public function import(string $source): array;
}
