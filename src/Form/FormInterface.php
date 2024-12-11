<?php

declare(strict_types=1);

namespace Gigamel\Form;

use Gigamel\Http\Protocol\ClientMessageInterface;

interface FormInterface extends TagInterface
{
    public function handle(ClientMessageInterface $message): bool;

    public function field(FieldInterface $field): FormInterface;

    public function render(string $view): string;
}
