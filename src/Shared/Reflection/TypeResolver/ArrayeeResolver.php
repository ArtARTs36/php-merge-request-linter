<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class ArrayeeResolver implements ArgumentResolver
{
    public const SUPPORT_TYPE = Arrayee::class;

    public function canResolve(Type $type, mixed $value): bool
    {
        return $type->class === self::SUPPORT_TYPE;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new ValueInvalidException(sprintf(
                'Arg with type %s not supported. Expected type: array',
                gettype($value),
            ));
        }

        return new Arrayee($value);
    }
}
