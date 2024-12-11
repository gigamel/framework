<?php

declare(strict_types=1);

namespace Gigamel\Frontend\View;

interface RenderableInterface
{
    public function render(string $view, array $vars = []): string;
}
