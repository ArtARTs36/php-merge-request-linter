<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\Str\Str;

class JsonType
{
    private const MAP = [
        Str::class => 'string',
        'int' => 'integer',
        'iterable' => 'array',
        'float' => 'number',
        'bool' => 'boolean',
    ];

    public static function to(string $type): string
    {
        if (isset(self::MAP[$type])) {
            return self::MAP[$type];
        }

        return $type;
    }
}
