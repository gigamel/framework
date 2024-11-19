<?php declare(strict_types=1);

namespace Gigamel\Form;

interface TypeFieldInterface
{
    public function valid(): bool;

    public function getErrors(): array;
}
