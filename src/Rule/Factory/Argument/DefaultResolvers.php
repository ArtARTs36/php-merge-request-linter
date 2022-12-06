<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

class DefaultResolvers
{
    public static function get(): array
    {
        return [
            'int' => new AsIsResolver(),
            'string' => new AsIsResolver(),
            'float' => new AsIsResolver(),
            'array' => new AsIsResolver(),
            MapResolver::SUPPORT_TYPE => MapResolver::class,
        ];
    }
}
