<?php

declare(strict_types=1);

namespace Slon\Frontend\View;

use SplFileInfo;

use function array_key_exists;
use function file_exists;

class RenderComposite implements RenderCompositeInterface
{
    /** @var RenderDriverInterface[] */
    protected array $drivers = [];

    public function setDriver(RenderDriverInterface $driver): void
    {
        $this->drivers[$driver->getExtension()] = $driver;
    }

    public function render(string $view, array $vars = []): string
    {
        if (!file_exists($view)) {
            return '';
        }

        $file = new SplFileInfo($view);
        if (array_key_exists($file->getExtension(), $this->drivers)) {
            return $this->drivers[$file->getExtension()]->render($view, $vars);
        }

        return '';
    }
}
