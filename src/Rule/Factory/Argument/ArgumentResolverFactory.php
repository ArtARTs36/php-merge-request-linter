<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ArrayObjectConverter;
use Psr\Container\ContainerInterface;

class ArgumentResolverFactory
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
        //
    }

    public function create(): ArgumentResolver
    {
        $asIsResolver = new AsIsResolver();
        $arrayObjectConverter = new ArrayObjectConverter();
        $genericAsIsResolver = new GenericResolver($asIsResolver, $arrayObjectConverter);
        $objectResolvers = [
            MapResolver::SUPPORT_TYPE => new GenericResolver(new MapResolver(), $arrayObjectConverter),
            SetResolver::SUPPORT_TYPE => new GenericResolver(new SetResolver(), $arrayObjectConverter),
            ArrayeeResolver::SUPPORT_TYPE => new GenericResolver(new ArrayeeResolver(), $arrayObjectConverter),
            ContainerResolver::NAME => new ContainerResolver($this->container),
        ];

        $resolvers = [
            'int' => $asIsResolver,
            'string' => $asIsResolver,
            'float' => $asIsResolver,
            'array' => $genericAsIsResolver,
            'object' => new ObjectCompositeResolver($objectResolvers),
            'iterable' => $genericAsIsResolver,
        ];

        return new CompositeResolver($resolvers);
    }
}
