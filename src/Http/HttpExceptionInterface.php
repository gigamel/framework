<?php declare(strict_types=1);

namespace Gigamel\Http;

interface HttpExceptionInterface
{
    public function getMessage(): string;

    public function getCode(): int;

    public function getHeaders(): array;
}
