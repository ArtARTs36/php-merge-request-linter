<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflector;

use ArtARTs36\Str\Str;

class ClassSummary
{
    public static function findInPhpDocComment(string $comment): ?string
    {
        $cleaned = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]?(.*)?#u', '$1', $comment);

        if ($cleaned === null) {
            return null;
        }

        return Str::make(trim($cleaned))
            ->lines()
            ->trim()
            ->filter(function (Str $str) {
                return ! $str->startsWith('@');
            })
            ->first();
    }
}
