<?php declare(strict_types=1);

namespace Gigamel\Import;

use function file_exists;
use function is_array;
use function str_ends_with;

class PhpArrayImporter implements ImportableInterface
{
    public function __construct(
        protected readonly string $source
    ) {
    }

    public function import(string $file): array
    {
        $path = $this->source . '/' . $file;
        if (file_exists($path) && str_ends_with($path, '.php')) {
            return is_array($a = require_once($path)) ? $a : [];
        }
        return [];
    }
}
