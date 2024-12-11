<?php

declare(strict_types=1);

namespace Gigamel\Import;

interface ImportableInterface
{
    public function import(string $file): array;
}
