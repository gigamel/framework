<?php declare(strict_types=1);

namespace Gigamel\Http;

interface HttpExceptionInterface
{
    public function getHeaders(): array;
}
