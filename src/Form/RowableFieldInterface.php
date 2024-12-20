<?php

declare(strict_types=1);

namespace Gigamel\Form;

interface RowableFieldInterface
{
    public function setValue(string $value): void;
}
