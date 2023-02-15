<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;

final class GenericResolver implements ArgumentResolver
{
    public function __construct(
        private readonly ArgumentResolver $resolver,
        private readonly ArrayObjectConverter $arrayObjectConverter = new ArrayObjectConverter(),
    ) {
        //
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        if ($type->isGenericOfObject() && is_array($value) && is_array(reset($value))) {
            $values = [];

            foreach ($value as $val) {
                //@phpstan-ignore-next-line
                $values[] = $this->arrayObjectConverter->convert($val, $type->generic);
            }

            $value = $values;
        }

        return $this->resolver->resolve($type, $value);
    }
}
