<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class GenericResolver implements ArgumentResolver
{
    public function __construct(
        private readonly ArgumentResolver $resolver,
        private readonly ArrayObjectConverter $arrayObjectConverter = new ArrayObjectConverter(),
    ) {
        //
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        return $this->resolver->canResolve($type, $value);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        $generic = $type->getObjectGeneric();

        if ($generic !== null && is_array($value) && is_array(reset($value))) {
            $values = [];

            foreach ($value as $val) {
                $values[] = $this->arrayObjectConverter->convert($val, $generic);
            }

            $value = $values;
        }

        return $this->resolver->resolve($type, $value);
    }
}
