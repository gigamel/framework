<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Gigamel\Form\AbstractStringableFieldInterface;

use function sprintf;

class Textarea extends AbstractStringableFieldInterface
{
    protected const string ATTR_NAME = 'name';

    protected array $attributes = [];

    public function __construct(
        string $name,
        array $attributes = []
    ) {
        $this->attributes[self::ATTR_NAME] = $name;
        $this->setAttributes($attributes);
    }

    public function getName(): string
    {
        return $this->attributes[self::ATTR_NAME];
    }

    public function render(): string
    {
        return sprintf(
            '<textarea%s>%s</textarea>',
            $this->renderAttributes(),
            $this->value
        );
    }

    protected function getExcludedAttributes(): array
    {
        return [
            self::ATTR_NAME,
        ];
    }
}
