<?php declare(strict_types=1);

namespace Gigamel\Form;

use function in_array;
use function sprintf;

class Form extends AbstractTag implements FormInterface
{
    protected const string ATTR_METHOD = 'method';

    protected const string ATTR_ACTION = 'action';

    protected const string ATTR_AUTOCOMPLETE = 'autocomplete';

    protected array $fields = [];

    protected array $buttonKeys = [];

    public function __construct(
        string $method,
        string $action = '',
        array $attributes = [],
        bool $autocomplete = false
    ) {
        $this->attributes[self::ATTR_METHOD] = $method;
        $this->attributes[self::ATTR_ACTION] = $action;

        if (!$autocomplete) {
            $this->attributes[self::ATTR_AUTOCOMPLETE] = 'off';
        }

        $this->setAttributes($attributes);
    }

    public function field(FieldInterface $field): FormInterface
    {
        $this->fields[$field->getName()] = $field;

        if ($field instanceof ButtonInterface) {
            $this->buttonKeys[] = $field->getName();
        }

        return $this;
    }

    public function render(): string
    {
        if (!$this->fields) {
            return '';
        }

        $fields = '';
        foreach ($this->fields as $field) {
            $fields .= $field->render();
        }

        return sprintf(
            '<form method="%s" action="%s"%s>%s</form>',
            $this->attributes[self::ATTR_METHOD],
            $this->attributes[self::ATTR_ACTION],
            $this->renderAttributes(),
            $fields
        );
    }

    public function handleClientMessage(): void
    {
        if (!$this->sent()) {
            return;
        }

        $data = $_POST;

        foreach ($this->fields as $field) {
            if (
                $field instanceof StringableDataInterface
                && array_key_exists($field->getName(), $data)
            ) {
                $field->setValue($data[$field->getName()]);
            }
        }
    }

    public function valid(): bool
    {
        if (!$this->fields) {
            return false;
        }

        $valid = true;
        foreach ($this->fields as $field) {
            if ($field instanceof TypeFieldInterface) {
                $valid = $valid && $field->valid();
            }
        }

        return $valid;
    }

    public function sent(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $this->attributes[self::ATTR_METHOD];
    }

    protected function getExcludedAttributes(): array
    {
        return [
            self::ATTR_METHOD,
            self::ATTR_ACTION,
            self::ATTR_AUTOCOMPLETE,
        ];
    }
}
