<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;

class DefaultResolvers
{
    /**
     * @return array<string, ArgResolver>
     */
    public static function get(): array
    {
        $asIsResolver = new AsIsResolver();

        return [
            'int' => $asIsResolver,
            'string' => $asIsResolver,
            'float' => $asIsResolver,
            'array' => $asIsResolver,
            MapResolver::SUPPORT_TYPE => new MapResolver(),
            SetResolver::SUPPORT_TYPE => new SetResolver(),
            'iterable' => $asIsResolver,
        ];
    }
}
