<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class MapCompositeResolver implements TypeResolver
{
    /**
     * @param array<string, TypeResolver> $resolvers
     */
    public function __construct(
        private array $resolvers = [],
    ) {
    }

    public function add(string $type, TypeResolver $typeResolver): self
    {
        $this->resolvers[$type] = $typeResolver;

        return $this;
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        return isset($this->resolvers[$type->name->value]) &&
            $this->resolvers[$type->name->value]->canResolve($type, $value);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if (! isset($this->resolvers[$type->name->value])) {
            throw new ValueInvalidException(sprintf(
                'Resolver for type "%s" not found',
                $type->name->value,
            ));
        }

        return $this->resolvers[$type->name->value]->resolve($type, $value);
    }
}
