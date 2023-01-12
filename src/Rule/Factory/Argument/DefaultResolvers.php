<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ArrayObjectConverter;

class DefaultResolvers
{
    /**
     * @return array<string, ArgumentResolver>
     */
    public static function get(): array
    {
        $asIsResolver = new AsIsResolver();
        $arrayObjectConverter = new ArrayObjectConverter();
        $genericAsIsResolver = new GenericResolver($asIsResolver, $arrayObjectConverter);

        return [
            'int' => $asIsResolver,
            'string' => $asIsResolver,
            'float' => $asIsResolver,
            'array' => $genericAsIsResolver,
            MapResolver::SUPPORT_TYPE => new GenericResolver(new MapResolver(), $arrayObjectConverter),
            SetResolver::SUPPORT_TYPE => new GenericResolver(new SetResolver(), $arrayObjectConverter),
            ArrayeeResolver::SUPPORT_TYPE => new GenericResolver(new ArrayeeResolver(), $arrayObjectConverter),
            'iterable' => $genericAsIsResolver,
        ];
    }
}
