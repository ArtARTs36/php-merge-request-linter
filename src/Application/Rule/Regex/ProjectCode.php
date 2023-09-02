<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Regex;

use ArtARTs36\Str\Str;

class ProjectCode
{
    /**
     * Find project code in string start.
     */
    public static function findInStart(Str $str): ?Str
    {
        $code = $str->match("/^(\w+)-\d+/");

        return $code->isEmpty() ? null : $code;
    }
}
