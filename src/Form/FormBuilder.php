<?php declare(strict_types=1);

namespace Gigamel\Form;

class FormBuilder implements FormBuilderInterface
{
    public function makeForm(
        string $method,
        string $action = '',
        array $attributes = [],
        bool $autocomplete = false
    ): FormInterface {
        return new Form($method, $action, $attributes, $autocomplete);
    }
}
