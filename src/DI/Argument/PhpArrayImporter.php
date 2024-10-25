<?php declare(strict_types=1);

namespace Gigamel\DI\Argument;

use function file_exists;
use function is_array;
use function str_ends_with;

class PhpArrayImporter implements ImporterInterface
{
    public function import(string $source): array
    {
        return str_ends_with($source, '.php') && file_exists($source) && is_array($a = require_once($source)) ? $a : [];
    }
}
