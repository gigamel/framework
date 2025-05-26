<?php

declare(strict_types=1);

namespace Slon\Event;

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
            $isStoppable = $this->instantiateObserver($observer)($event);
            if ($isStoppable) {
                break;
            }
        }

        unset($this->observers[$eventName]);
    }
}
