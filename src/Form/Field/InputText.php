<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Attribute;
use Gigamel\Form\Attributes;
use Gigamel\Form\FieldInterface;

use function array_replace;
use function sprintf;

#[Attribute]
class InputText implements FieldInterface
{
    protected array $attributes = [];

    public function __construct(
        array $attributes = []
    ) {
        $this->setAttributes($attributes);
    }

    public function render(): string
    {
        return sprintf('<input%s/>', Attributes::render($this->attributes));
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = array_replace($this->attributes, $attributes);
    }
}
