<?php

declare(strict_types=1);

namespace Slon\Import;

interface ImporterInterface
{
    public function import(string $file): array;
}
