<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FormInterface extends TagInterface
{
    public function field(FieldInterface $field): FormInterface;

    public function valid(): bool;

    public function sent(): bool;
}
