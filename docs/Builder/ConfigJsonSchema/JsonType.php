<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\Str\Str;

class JsonType
{
    public static function to(string $type): string
    {
        if ($type === Str::class) {
            return 'string';
        }

        if ($type === 'int') {
            return 'integer';
        }

        if ($type === 'iterable') {
            return 'array';
        }

        if ($type === 'float') {
            return 'number';
        }

        if ($type === 'bool') {
            return 'boolean';
        }

        return $type;
    }
}
