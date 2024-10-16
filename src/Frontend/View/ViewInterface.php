<?php declare(strict_types=1);

namespace Gigamel\Frontend\View;

interface ViewInterface
{
    public function render(string $view, array $vars = []): string;
}
