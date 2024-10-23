<?php declare(strict_types=1);

namespace Gigamel\Frontend\View;

interface RenderDriverInterface extends ViewInterface
{
    public function isCompatible(string $view): bool;
}
