<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

class ObjectCompositeResolver implements ArgumentResolver
{
    public const NAME = 'object';

    /**
     * @param array<string, ArgumentResolver> $resolvers
     */
    public function __construct(
        private readonly array $resolvers,
    ) {
        //
    }

    public function resolve(ParameterType $type, mixed $value): mixed
    {
        $resolver = $this->resolvers[$type->class] ?? $this->resolvers[ContainerResolver::NAME] ?? null;

        if ($resolver === null) {
            throw new ArgNotSupportedException(sprintf(
                'Resolver for type "%s" not found',
                $type->class,
            ));
        }

        return $resolver->resolve($type, $value);
    }
}
