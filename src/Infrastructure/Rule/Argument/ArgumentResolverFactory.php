<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ArrayeeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\GenericResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\MapResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ObjectCompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\SetResolver;
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
