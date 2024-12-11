<?php

declare(strict_types=1);

namespace Gigamel\Frontend\View\Driver;

use Gigamel\Frontend\View\RenderDriverInterface;

use function ob_get_clean;
use function str_ends_with;

final class PhpRenderDriver implements RenderDriverInterface
{
    public function getExtension(): string
    {
        return 'php';
    }

    public function render(string $view, array $vars = []): string
    {
        extract($vars);
        unset($params);

        try {
            ob_start();
            require($view);
        } finally {
            return ob_get_clean() ?: '';
        }
    }
}
