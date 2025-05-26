<?php

declare(strict_types=1);

namespace Slon\Import;

use function file_exists;
use function is_array;
use function str_ends_with;

class PhpArrayImporter implements ImporterInterface
{
    public function import(string $file): array
    {
        if (file_exists($file) && str_ends_with($file, '.php')) {
            return is_array($a = require_once($file)) ? $a : [];
        }
        return [];
    }
}
