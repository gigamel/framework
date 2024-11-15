<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FormBuilderInterface
{
    public function makeForm(array $attributes = []): FormInterface;
}
