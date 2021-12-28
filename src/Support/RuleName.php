<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use ArtARTs36\Str\Str;

class RuleName
{
    public static function fromClass(string $class): string
    {
        return Str::make($class)
            ->explode('\\')
            ->last()
            ->deleteWhenEnds('Rule')
            ->splitByDifferentCases()
            ->toLower()
            ->implode('_');
    }
}
