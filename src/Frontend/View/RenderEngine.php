<?php declare(strict_types=1);

namespace Gigamel\Frontend\View;

use InvalidArgumentException;
use RuntimeException;

use function file_exists;

class RenderEngine implements RenderEngineInterface
{
    protected array $drivers = [];

    public function __construct(RenderDriverInterface ...$drivers)
    {
        $this->drivers = $drivers;
    }

    public function setDriver(RenderDriverInterface $driver): void
    {
        $this->drivers[] = $driver;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function render(string $view, array $vars = []): string
    {
        if (!file_exists($view)) {
            throw new InvalidArgumentException(sprintf(
                'File of view [%s] is not exists',
                $view
            ));
        }

        foreach ($this->drivers as $driver) {
            if ($driver->isCompatible($view)) {
                return $driver->render($view, $vars);
            }
        }

        throw new RuntimeException(sprintf(
            'Please install render driver for extension of file [%s]',
            $view
        ));
    }
}
