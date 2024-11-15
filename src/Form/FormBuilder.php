<?php declare(strict_types=1);

namespace Gigamel\Form;

class FormBuilder implements FormBuilderInterface
{
    public function makeForm(array $attributes = []): FormInterface
    {
        return new Form($attributes);
    }
}
