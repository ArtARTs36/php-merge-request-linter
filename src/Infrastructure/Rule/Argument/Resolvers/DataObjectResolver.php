<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;

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
        return $type->class !== null;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        $class = $type->class;

        if ($class === null || ! class_exists($class)) {
            throw new ArgNotSupportedException(sprintf(
                'Type with name "%s" not supported',
                $type->name->value,
            ));
        }

        return $this->converter->convert($value ?? [], $class);
    }
}
