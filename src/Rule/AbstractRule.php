<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Support\RuleName;

abstract class AbstractRule implements Rule
{
    protected function createDefinition(string $description): RuleDefinition
    {
        return new Definition($description, RuleName::fromClass(static::class));
    }
}
