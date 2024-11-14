<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FieldInterface
{
    public function render(): string;

    public function setAttributes(array $attributes): void;
}
