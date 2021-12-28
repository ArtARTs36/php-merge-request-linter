<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\Str\Str;

trait HasName
{
    public function getName(): string
    {
        return Str::make(static::class)
            ->explode('\\')
            ->last()
            ->deleteWhenEnds('Rule')
            ->splitByDifferentCases()
            ->toLower()
            ->implode('_');
    }
}
