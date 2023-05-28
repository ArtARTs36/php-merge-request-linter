<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ArrayObjectConverter;
use Psr\Container\ContainerInterface;

class TypeResolverFactory
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
            new GenericResolver(new MapResolver(), $arrayObjectConverter),
            new GenericResolver(new SetResolver(), $arrayObjectConverter),
            new GenericResolver(new ArrayeeResolver(), $arrayObjectConverter),
            new ContainerResolver($this->container),
            new DataObjectResolver($arrayObjectConverter),
            new EnumResolver(),
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
