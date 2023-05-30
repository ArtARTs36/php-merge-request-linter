<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class DateTimeResolver implements TypeResolver
{
    public function canResolve(Type $type, mixed $value): bool
    {
        return in_array($type->class, [
            \DateTimeInterface::class,
            \DateTimeImmutable::class,
            \DateTime::class,
        ]);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if ($type->class === null || ! is_string($value)) {
            throw new ValueInvalidException(sprintf(
                'Arg with type %s not supported. Expected type: string of date',
                gettype($value),
            ));
        }

        if ($type->class === \DateTime::class) {
            return new \DateTime($value);
        }

        return new \DateTimeImmutable($value);
    }
}
