<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Gigamel\Form\AbstractStringableFieldInterface;

use function array_replace;
use function sprintf;

class InputText extends AbstractStringableFieldInterface
{
    protected const string ATTR_TYPE = 'type';

    protected const string ATTR_NAME = 'name';

    protected const string ATTR_VALUE = 'value';

    protected array $attributes = [];

    public function __construct(
        string $name,
        array $attributes = []
    ) {
        $this->attributes[self::ATTR_NAME] = $name;
        $this->attributes[self::ATTR_TYPE] = 'text';
        $this->setAttributes($attributes);
    }

    public function getName(): string
    {
        return $this->attributes[self::ATTR_NAME];
    }

    public function render(): string
    {
        return sprintf(
            '<input value="%s"%s/>',
            $this->value,
            $this->renderAttributes()
        );
    }

    protected function getExcludedAttributes(): array
    {
        return [
            self::ATTR_NAME,
            self::ATTR_TYPE,
            self::ATTR_VALUE,
        ];
    }
}
