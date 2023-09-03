<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Instantiator;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\TypeResolver;

class ParameterMapBuilder
{
    public function __construct(
        private readonly TypeResolver $argResolver,
    ) {
        //
    }

    /**
     * @template T as object
     * @param Instantiator<T> $constructor
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function build(Instantiator $constructor, array $params): array
    {
        $args = [];

        foreach ($constructor->params() as $paramName => $param) {
            $val = null;

            if (! array_key_exists($paramName, $params) && $param->hasDefaultValue) {
                $val = $param->getDefaultValue();
            } else {
                $val = $this->argResolver->resolve($param->type, $params[$paramName] ?? null);
            }

            $args[$paramName] = $val;
        }

        return $args;
    }
}
