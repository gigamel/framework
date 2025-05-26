<?php

declare(strict_types=1);

namespace Slon\Form\Field;

use Slon\Form\AbstractTag;
use Slon\Form\Attribute;
use Slon\Form\FieldInterface;
use Slon\Form\RowableFieldInterface;

use function sprintf;
use function str_replace;

class RowableSelect extends AbstractTag implements FieldInterface, RowableFieldInterface
{
    protected string $value = '';

    public function __construct(
        string $name,
        protected array $options = [],
        array $attributes = []
    ) {
        $this->attributes[Attribute::NAME] = $name;
        $this->setAttributes($attributes);
    }

    public function getName(): string
    {
        return $this->attributes[Attribute::NAME];
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function render(string $contents): string
    {
        return str_replace(
            sprintf('{{ field_%s }}', $this->getName()),
            sprintf('<select%s>%s</select>', $this->renderAttributes(), $this->renderOptions()),
            $contents
        );
    }

    protected function renderOptions(): string
    {
        $options = '';
        foreach ($this->options as $value => $label) {
            $options .= sprintf(
                '<option value="%s"%s>%s</option>',
                $value,
                ($this->value === (string) $value) ? ' selected' : '',
                $label
            );
        }
        return $options;
    }

    protected function getAttributesExcluded(): array
    {
        return [
            Attribute::MULTIPLE,
            Attribute::NAME,
            Attribute::VALUE,
        ];
    }
}
