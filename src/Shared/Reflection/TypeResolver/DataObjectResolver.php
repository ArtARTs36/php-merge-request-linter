<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class DataObjectResolver implements ArgumentResolver
{
    public const NAME = 'data_object';

    public function __construct(
        private readonly ArrayObjectConverter $converter,
    ) {
        //
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        return $type->class !== null && (is_array($value) || $value === null);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        $class = $type->class;

        if ($class === null || ! class_exists($class)) {
            throw new ValueInvalidException(sprintf(
                'Type with name "%s" not supported',
                $class ?? $type->name->value,
            ));
        }

        if (! is_array($value) && $value !== null) {
            throw new ValueInvalidException(sprintf(
                'Value for type with name "%s" must be array or null, given %s',
                $class,
                gettype($value),
            ));
        }

        return $this->converter->convert($value ?? [], $class);
    }
}
