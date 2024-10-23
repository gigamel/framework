<?php declare(strict_types=1);

namespace Gigamel\Frontend\View\Driver;

use Gigamel\Frontend\View\RenderDriverInterface;

use function str_ends_with;

final class PhpRenderDriver implements RenderDriverInterface
{
    public function isCompatible(string $view): bool
    {
        return str_ends_with($view, '.php');
    }

    public function render(string $view, array $vars = []): string
    {
        extract($vars);
        unset($params);
        ob_start();
        require $view;
        return ob_get_clean() ?: '';
    }
}
