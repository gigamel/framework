<?php declare(strict_types=1);

namespace Gigamel\Form;

abstract class AbstractStringableFieldInterface extends AbstractTag implements StringableDataInterface, FieldInterface
{
    protected string $value = '';

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
