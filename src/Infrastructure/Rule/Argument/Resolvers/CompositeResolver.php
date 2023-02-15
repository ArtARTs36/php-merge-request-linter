<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

final class CompositeResolver implements ArgumentResolver
{
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
        if (! isset($this->resolvers[$type->name->value])) {
            throw new ArgNotSupportedException(sprintf(
                'Resolver for type "%s" not found',
                $type->name->value,
            ));
        }

        return $this->resolvers[$type->name->value]->resolve($type, $value);
    }
}
