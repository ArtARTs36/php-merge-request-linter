<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

final class ObjectCompositeResolver implements ArgumentResolver
{
    public const NAME = 'object';

    /**
     * @param array<ArgumentResolver> $resolvers
     */
    public function __construct(
        private readonly array $resolvers,
    ) {
        //
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->canResolve($type, $value)) {
                return true;
            }
        }

        return false;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->canResolve($type, $value)) {
                return $resolver->resolve($type, $value);
            }
        }

        throw new ArgNotSupportedException(sprintf(
            'Resolver for type "%s" not found',
            $type->class,
        ));
    }
}
