<?php

declare(strict_types=1);

namespace Slon\Frontend\View;

interface RenderCompositeInterface extends RenderableInterface
{
    public function setDriver(RenderDriverInterface $driver): void;
}
