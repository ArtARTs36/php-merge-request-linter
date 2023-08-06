<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive;

use ArtARTs36\Str\Str;

class Scrubber
{
    public static function scrub(string $text): string
    {
        $login = Str::make($text);
        $length = $login->length();

        $hidden = $login->firstSymbol();

        for ($i = 1; $i < $length - 1; $i++) {
            $hidden .= '*';
        }

        return $hidden . $login->lastSymbol();
    }
}
