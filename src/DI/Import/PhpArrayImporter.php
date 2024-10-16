<?php declare(strict_types=1);

namespace Gigamel\DI\Import;

use function file_exists;
use function is_array;
use function str_ends_with;

class PhpArrayImporter implements ImporterInterface
{
    public function import(string $source): array
    {
        if (str_ends_with($source, '.php') && file_exists($source)) {
            $data = require_once($source);
        }
        return is_array($data ?? null) ? $data : [];
    }
}
