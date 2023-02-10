<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Common\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Common\Reflector\ParameterType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;

final class GenericResolver implements ArgumentResolver
{
    public function __construct(
        private readonly ArgumentResolver $resolver,
        private readonly ArrayObjectConverter $arrayObjectConverter = new ArrayObjectConverter(),
    ) {
        //
    }

    public function resolve(ParameterType $type, mixed $value): mixed
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
