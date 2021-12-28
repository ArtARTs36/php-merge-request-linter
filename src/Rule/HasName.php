<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Support\RuleName;

trait HasName
{
    public function getName(): string
    {
        return RuleName::fromClass(static::class);
    }
}
