<?php declare(strict_types=1);

namespace Gigamel\Frontend\View;

interface RenderEngineInterface extends ViewInterface
{
    public function setDriver(RenderDriverInterface $driver): void;
}
