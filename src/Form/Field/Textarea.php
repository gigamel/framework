<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Attribute;
use Gigamel\Form\Attributes;
use Gigamel\Form\FieldInterface;

use function array_replace;
use function sprintf;

#[Attribute]
class Textarea implements FieldInterface
{
    protected array $attributes = [];

    public function __construct(
        array $attributes = []
    ) {
        $this->setAttributes($attributes);
    }

    public function render(): string
    {
        return sprintf(
            '<textarea%s></textarea>',
            Attributes::render($this->attributes)
        );
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = array_replace($this->attributes, $attributes);
    }
}
