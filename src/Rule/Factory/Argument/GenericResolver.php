<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

class GenericResolver implements ArgumentResolver
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

            return $values;
        }

        return $this->resolver->resolve($type, $value);
    }
}