<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Common\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

final class ObjectCompositeResolver implements ArgumentResolver
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

    public function resolve(Type $type, mixed $value): mixed
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
