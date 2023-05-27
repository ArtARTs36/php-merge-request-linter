<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

class JsonType
{
    public const OBJECT = 'object';
    public const INTEGER = 'integer';
    public const STRING = 'string';

    private const MAP = [
        Str::class => self::STRING,
        Set::class => 'array',
        Arrayee::class => 'array',
        'int' => self::INTEGER,
        'integer' => self::INTEGER,
        'iterable' => 'array',
        'float' => 'number',
        'bool' => 'boolean',
        'array' => 'array',
        'string' => self::STRING,
    ];

    public static function to(string $type): ?string
    {
        if (isset(self::MAP[$type])) {
            return self::MAP[$type];
        }

        if (class_exists($type)) {
            if (enum_exists($type)) {
                return is_subclass_of($type, \IntBackedEnum::class, true) ?
                    self::INTEGER :
                    self::STRING;
            }

            return self::OBJECT;
        }

        return null;
    }
}
