<?php declare(strict_types=1);

namespace Gigamel\Form;

interface FormBuilderInterface
{
    public function makeForm(
        string $method,
        string $action = '',
        array $attributes = [],
        bool $autocomplete = false
    ): FormInterface;
}
