<?php

declare(strict_types=1);

namespace Slon\Frontend\View;

interface RenderableInterface
{
    public function render(string $view, array $vars = []): string;
}
