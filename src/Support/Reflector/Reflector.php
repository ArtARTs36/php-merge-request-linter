<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

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

    /**
     * @param class-string $class
     * @return array<string, ParameterType>
     */
    public static function mapPropertyTypes(string $class): array
    {
        $reflector = new \ReflectionClass($class);

        $map = [];

        foreach ($reflector->getProperties() as $property) {
            $genericAttributes = $property->getAttributes(Generic::class);
            $generic = null;

            if (count($genericAttributes) === 1) {
                $genericAttr = current($genericAttributes);
                $generic = current($genericAttr->getArguments());
            }

            $map[$property->getName()] = new ParameterType($property->getType()->getName(), $generic);
        }

        return $map;
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

    /**
     * @param \ReflectionClass<object> $reflector
     * @param class-string $attributeClass
     */
    public static function hasAttribute(\ReflectionClass $reflector, string $attributeClass): bool
    {
        return count($reflector->getAttributes($attributeClass)) > 0;
    }

    /**
     * @param \ReflectionClass<object> $reflector
     */
    public static function findPHPDocSummary(\ReflectionClass $reflector): ?string
    {
        $comment = $reflector->getDocComment();

        if ($comment === false) {
            return null;
        }

        $cleaned = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]?(.*)?#u', '$1', $comment);

        if ($cleaned === null) {
            return null;
        }

        return trim($cleaned);
    }
}
