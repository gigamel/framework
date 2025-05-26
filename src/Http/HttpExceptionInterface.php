<?php

declare(strict_types=1);

namespace Slon\Http;

interface HttpExceptionInterface
{
    public function getHeaders(): array;
}
