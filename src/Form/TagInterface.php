<?php

declare(strict_types=1);

namespace Slon\Form;

interface TagInterface
{
    public function setAttribute(string $name, string $value): void;
}
