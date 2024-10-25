<?php declare(strict_types=1);

namespace Gigamel\Event;

use function array_key_exists;

class EventsObserver implements EventsObserverInterface
{
    protected array $observers = [];

    public function addObserver(string $eventName, string $observer): void
    {
        $this->observers[$eventName][] = $observer;
    }

    public function observe(object $event, ?string $eventName = null): void
    {
        $eventName ??= $event::class;
        if (!array_key_exists($eventName, $this->observers)) {
            return;
        }

        foreach ($this->observers[$eventName] as $observer) {
            $this->instantiateObserver($observer)($event);
        }

        unset($this->observers[$eventName]);
    }

    protected function instantiateObserver(string $observer): callable
    {
        return new $observer(...array_values($observer));
    }

    protected function getObserverArguments(string $observer): array
    {
        return [];
    }
}
