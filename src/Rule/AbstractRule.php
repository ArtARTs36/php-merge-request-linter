<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;

abstract class AbstractRule implements Rule
{
    public const NAME = '@mr-linter/abstract_rule';

    public function getName(): string
    {
        return static::NAME;
    }
}
