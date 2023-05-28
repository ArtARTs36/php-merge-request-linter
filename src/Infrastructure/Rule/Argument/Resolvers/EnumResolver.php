<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;

final class EnumResolver implements ArgumentResolver
{
    public function canResolve(Type $type, mixed $value): bool
    {
        return $type->class !== null && enum_exists($type->class);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if ($type->class === null) {
            throw new ArgNotSupportedException(sprintf(
                'Type with name "%s" not supported',
                $type->name->value,
            ));
        }

        if (! enum_exists($type->class)) {
            throw new ArgNotSupportedException(sprintf(
                'Type with name "%s" not supported',
                $type->class,
            ));
        }

        /** @var class-string<\BackedEnum> $enum */
        $enum = $type->class;

        try {
            return $enum::from($value);
        } catch (\Throwable $e) {
            throw new ArgNotSupportedException(
                sprintf(
                    'Enum "%s" not resolved. Available values: [%s]',
                    $enum,
                    implode(', ', array_map(fn (\UnitEnum $unit) => $unit->value, $enum::cases())),
                ),
                previous: $e,
            );
        }
    }
}
