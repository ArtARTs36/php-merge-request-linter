<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Str;

class JsonType
{
    public const OBJECT = 'object';

    private const MAP = [
        Str::class => 'string',
        Set::class => 'array',
        Arrayee::class => 'array',
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
