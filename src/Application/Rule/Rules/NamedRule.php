<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

abstract class NamedRule implements Rule
{
    public const NAME = '@mr-linter/abstract_rule';

    public function getName(): string
    {
        return static::NAME;
    }
}
