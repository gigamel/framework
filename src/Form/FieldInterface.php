<?php

declare(strict_types=1);

namespace Slon\Form;

interface FieldInterface extends TagInterface
{
    public function getName(): string;

    public function render(string $contents): string;
}
