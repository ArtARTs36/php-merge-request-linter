<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\Str\Str;

class JsonType
{
    public const OBJECT = 'object';

    private const MAP = [
        Str::class => 'string',
        Set::class => 'array',
        Arrayee::class => 'array',
        'int' => 'integer',
        'integer' => 'integer',
        'iterable' => 'array',
        'float' => 'number',
        'bool' => 'boolean',
        'array' => 'array',
        'string' => 'string',
    ];

    public static function to(string $type): ?string
    {
        if (isset(self::MAP[$type])) {
            return self::MAP[$type];
        }

        return null;
    }
}
