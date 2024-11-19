<?php declare(strict_types=1);

namespace Gigamel\Form\Field;

use Gigamel\Form\AbstractTag;
use Gigamel\Form\ButtonInterface;

use function sprintf;

class Button extends AbstractTag implements ButtonInterface
{
    protected const string ATTR_PLACEHOLDER = 'placeholder';

    protected const string ATTR_NAME = 'name';

    protected array $attributes = [];

    public function __construct(
        string $name,
        protected string $label = 'Save',
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
            '<button%s>%s</button>',
            $this->renderAttributes(),
            $this->label
        );
    }

    protected function getExcludedAttributes(): array
    {
        return [
            self::ATTR_NAME,
            self::ATTR_PLACEHOLDER,
        ];
    }
}
