<?php

declare(strict_types=1);

namespace Gigamel\Form;

use Gigamel\Http\Protocol\ClientMessageInterface;

use function array_key_exists;
use function file_exists;
use function file_get_contents;
use function sprintf;

class Form extends AbstractTag implements FormInterface
{
    protected array $fields = [];

    public function __construct(
        protected string $method,
        protected string $action = '',
        array $attributes = [],
        bool $autocomplete = false
    ) {
        $this->attributes[Attribute::METHOD] = $method;
        $this->attributes[Attribute::ACTION] = $action;

        if (!$autocomplete) {
            $this->attributes[Attribute::AUTOCOMPLETE] = 'off';
        }

        $this->setAttributes($attributes);
    }

    public function handle(ClientMessageInterface $message): bool
    {
        if (!$message->isMethod($this->attributes[Attribute::METHOD])) {
            return false;
        }

        foreach ($this->fields as $name => $field) {
            if ($field instanceof RowableFieldInterface) {
                $field->setValue($_POST[$name] ?? '');
            }
        }

        return true;
    }

    public function field(FieldInterface $field): FormInterface
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function render(string $view): string
    {
         if (!file_exists($view) || !$this->fields) {
             return '';
         }

         return sprintf(
             '<form%s>%s</form>',
             $this->renderAttributes(),
             $this->renderFields(file_get_contents($view) ?: '')
         );
    }

    protected function renderFields(string $contents): string
    {
        foreach ($this->fields as $field) {
            $contents = $field->render($contents);
        }
        return $contents;
    }

    protected function getAttributesExcluded(): array
    {
        return [
            Attribute::ACTION,
            Attribute::AUTOCOMPLETE,
            Attribute::METHOD,
            Attribute::NAME,
            Attribute::TYPE,
            Attribute::VALUE,
        ];
    }
}
