<?php

declare(strict_types=1);

namespace Slon\Import;

use InvalidArgumentException;
use SplFileInfo;

use function array_key_exists;
use function file_exists;
use function sprintf;

class ImporterAggregator implements ImporterAggregatorInterface
{
    /** @var array <string, ImporterInterface> */
    protected array $importers = [];
    
    public function __construct(array $importers = [])
    {
        foreach ($importers as $extension => $importer) {
            $this->addImporter($extension, $importer);
        }
    }

    public function addImporter(
        string $extension,
        ImporterInterface $importer,
    ): void {
        if ($this === $importer) {
            throw new InvalidArgumentException(sprintf(
                'Detected circular ref "%s" in class "%s"',
                $importer::class,
                static::class,
            ));
        }
        
        $this->importers[$extension] = $importer;
    }
    
    public function import(string $file): array
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException(sprintf(
                'File "%s" is not exists',
                $file,
            ));
        }
        
        $splFile = new SplFileInfo($file);
        if (!array_key_exists($splFile->getExtension(), $this->importers)) {
            throw new InvalidArgumentException(sprintf(
                'Undefined importer for "%s"',
                $splFile->getExtension(),
            ));
        }
        
        return $this->importers[$splFile->getExtension()]->import(
            $splFile->getRealPath(),
        );
    }
}
