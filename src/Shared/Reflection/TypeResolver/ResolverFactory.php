<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use Psr\Container\ContainerInterface;

class ResolverFactory
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
        //
    }

    public function create(): TypeResolver
    {
        $composite = new CompositeResolver();

        $asIsResolver = new AsIsResolver();

        // add primitive resolvers

        $composite
            ->add('int', $asIsResolver)
            ->add('string', $asIsResolver)
            ->add('float', $asIsResolver)
            ->add('array', $asIsResolver);

        // add object resolvers

        $arrayObjectConverter = new ArrayObjectConverter($composite);
        $genericAsIsResolver = new GenericResolver($asIsResolver, $arrayObjectConverter);
        $objectResolvers = [
            new GenericResolver(new MapResolver(), $arrayObjectConverter),
            new GenericResolver(new SetResolver(), $arrayObjectConverter),
            new GenericResolver(new ArrayeeResolver(), $arrayObjectConverter),
            new ContainerResolver($this->container),
            new DataObjectResolver($arrayObjectConverter),
            new EnumResolver(),
            new DateTimeResolver(),
        ];

        $composite
            ->add('object', new ObjectCompositeResolver($objectResolvers))
            ->add('iterable', $genericAsIsResolver);

        return $composite;
    }
}
