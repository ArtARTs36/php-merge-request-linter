<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ArrayeeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\GenericResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\MapResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ObjectCompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\SetResolver;
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
            new GenericResolver(new MapResolver(), $arrayObjectConverter),
            new GenericResolver(new SetResolver(), $arrayObjectConverter),
            new GenericResolver(new ArrayeeResolver(), $arrayObjectConverter),
            new ContainerResolver($this->container),
            new DataObjectResolver($arrayObjectConverter),
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
