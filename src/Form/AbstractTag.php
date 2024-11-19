<?php declare(strict_types=1);

namespace Gigamel\Form;

use function in_array;
use function sprintf;

abstract class AbstractTag implements TagInterface
{
    protected array $attributes = [];

    public function setAttribute(string $name, string $value): void
    {
        if (!in_array($name, $this->getExcludedAttributes(), true)) {
            $this->attributes[$name] = $value;
        }
    }

    protected function renderAttributes(): string
    {
        $attributes = '';
        foreach ($this->attributes as $name => $value) {
            $attributes .= sprintf(' %s="%s"', $name, $value);
        }
        return $attributes;
    }

    protected function setAttributes(array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    abstract protected function getExcludedAttributes(): array;
}
