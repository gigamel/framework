<?php

declare(strict_types=1);

namespace Slon\ODR\Meta;

interface MetaInstanceInterface
{
    public function addArgument(string $name, ReferenceInterface $reference): self;

    /**
     * @return array<string, ReferenceInterface>
     */
    public function getArguments(): array;

    public function getClassName(): string;
    
    public function getId(): string;
}
