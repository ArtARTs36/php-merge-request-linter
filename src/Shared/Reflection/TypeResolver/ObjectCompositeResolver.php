<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class ObjectCompositeResolver implements TypeResolver
{
    public const NAME = 'object';

    /**
     * @param array<TypeResolver> $resolvers
     */
    public function __construct(
        private readonly array $resolvers,
    ) {
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

        throw new ValueInvalidException(sprintf(
            'Resolver for type "%s" not found',
            $type->class,
        ));
    }
}
