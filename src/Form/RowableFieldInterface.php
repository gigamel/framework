<?php

declare(strict_types=1);

namespace App\Form;

interface RowableFieldInterface
{
    public function setValue(string $value): void;
}
