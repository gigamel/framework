<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FieldInterface extends TagInterface
{
    public function getName(): string;
}
