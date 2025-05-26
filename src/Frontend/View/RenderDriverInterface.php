<?php

declare(strict_types=1);

namespace Slon\Frontend\View;

interface RenderDriverInterface extends RenderableInterface
{
    public function getExtension(): string;
}
