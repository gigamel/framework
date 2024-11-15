<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FormInterface
{
    public function fromEntity(string $entity): self;

    public function field(FieldInterface $field, ?string $name = null): self;

    public function render(): string;
}
