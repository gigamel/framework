<?php

declare(strict_types=1);

namespace Slon\DI\Import;

interface ImporterAggregatorInterface extends ImporterInterface
{
    public function addImporter(
        string $extension,
        ImporterInterface $importer,
    ): void;
}
