<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class GenericResolver implements TypeResolver
{
    public function __construct(
        private readonly TypeResolver         $resolver,
        private readonly ArrayObjectConverter $arrayObjectConverter,
    ) {
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
