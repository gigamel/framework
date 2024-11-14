<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Gigamel\Form\Attributes;
use Gigamel\Form\FieldInterface;

use function array_replace;
use function sprintf;

class Button implements FieldInterface
{
    protected array $attributes = [];

    public function __construct(
        protected string $placeholder = 'Save',
        array $attributes = []
    ) {
        $this->setAttributes($attributes);
    }

    public function render(): string
    {
        return sprintf('<button%s>%s</button>', Attributes::render($this->attributes), $this->placeholder);
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = array_replace($this->attributes, $attributes);
    }
}
