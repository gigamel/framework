<?php declare(strict_types=1);

namespace Gigamel\Event\Argument;

interface ObserverParserInterface
{
    public function getArguments(string $observer): array;
}
