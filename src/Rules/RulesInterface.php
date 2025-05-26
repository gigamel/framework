<?php

declare(strict_types=1);

namespace Slon\Rules;

interface RulesInterface
{
    public function getRules(): array;
    
    public function getArguments(): array;
}
