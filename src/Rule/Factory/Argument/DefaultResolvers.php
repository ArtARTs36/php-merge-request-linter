<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

class DefaultResolvers
{
    public static function get(): array
    {
        $asIsResolver = new AsIsResolver();

        return [
            'int' => $asIsResolver,
            'string' => $asIsResolver,
            'float' => $asIsResolver,
            'array' => $asIsResolver,
            MapResolver::SUPPORT_TYPE => MapResolver::class,
            'iterable' => $asIsResolver,
        ];
    }
}
