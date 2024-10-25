<?php declare(strict_types=1);

namespace Gigamel\Frontend\View;

interface RenderCompositeInterface extends RenderableInterface
{
    public function setDriver(RenderDriverInterface $driver): void;
}
