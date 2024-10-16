<?php declare(strict_types=1);

namespace Gigamel\Frontend\View\Widget;

abstract class AbstractWidget implements WidgetInterface
{
    public function __call(string $name, array $arguments): mixed
    {
        return $this;
    }
}
