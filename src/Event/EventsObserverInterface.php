<?php declare(strict_types=1);

namespace Gigamel\Event;

interface EventsObserverInterface
{
    public function addObserver(string $eventName, string $observer): void;

    public function observe(object $event, ?string $eventName = null): void;
}
