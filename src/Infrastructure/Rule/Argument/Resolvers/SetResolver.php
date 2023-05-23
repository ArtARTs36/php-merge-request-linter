<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

final class SetResolver implements ArgumentResolver
{
    public const SUPPORT_TYPE = Set::class;

    public function canResolve(Type $type, mixed $value): bool
    {
        return $type->class === self::SUPPORT_TYPE;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new ArgNotSupportedException(sprintf(
                'Arg with type %s not supported. Expected type: array',
                gettype($value),
            ));
        }

        return Set::fromList($value);
    }
}
