<?php

declare(strict_types=1);

namespace Slon\Form;

interface RowableFieldInterface
{
    public function setValue(string $value): void;
}
