<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use ArtARTs36\MergeRequestLinter\Attribute\Generic;

class Reflector
{
    /**
     * @return array<string, ParameterType>
     * @throws \Exception
     */
    public static function mapMethodParamTypeOnParam(\ReflectionMethod $method): array
    {
        $params = [];

        foreach ($method->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (! $type instanceof \ReflectionNamedType) {
                throw new \Exception(sprintf('Parameter %s::%s doesnt have type', $method->class, $method->getName()));
            }

            $genericAttributes = $parameter->getAttributes(Generic::class);
            $generic = null;

            if (count($genericAttributes) === 1) {
                $genericAttr = current($genericAttributes);
                $generic = current($genericAttr->getArguments());
            }

            $params[$parameter->getName()] = new ParameterType($type->getName(), $generic);
        }

        return $params;
    }

    public static function findParamByName(\ReflectionMethod $method, string $name): ?\ReflectionParameter
    {
        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }

        return null;
    }

    public static function hasAttribute(\ReflectionClass $reflector, string $attributeClass): bool
    {
        return count($reflector->getAttributes($attributeClass)) > 0;
    }
}
