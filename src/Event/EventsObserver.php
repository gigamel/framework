<?php declare(strict_types=1);

namespace Gigamel\Event;

use Gigamel\Event\Argument\ObserverParserInterface;

use function array_key_exists;

class EventsObserver implements EventsObserverInterface
{
    protected array $observers = [];

    protected ?ObserverParserInterface $parser = null;

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

    public function setObserverParser(ObserverParserInterface $parser): void
    {
        $this->parser = $parser;
    }

    protected function instantiateObserver(string $observer): callable
    {
        return new $observer(...array_values(
            $this->getObserverArguments($observer)
        ));
    }

    protected function getObserverArguments(string $observer): array
    {
        return $this->parser ? $this->parser->getArguments($observer) : [];
    }
}
