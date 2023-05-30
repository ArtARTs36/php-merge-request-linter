<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;

class Reflector
{
    /**
     * @return array<string, Parameter>
     * @throws \Exception
     */
    public static function mapParamNameOnParam(\ReflectionMethod $method): array
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

            $params[$parameter->getName()] = new Parameter(
                $parameter->getName(),
                self::findDescription($parameter)?->description ?? '',
                self::createType(
                    $type->getName(),
                    $generic,
                    $parameter->allowsNull(),
                ),
                $parameter->isDefaultValueAvailable(),
                fn () => $parameter->getDefaultValue(),
            );
        }

        return $params;
    }

    private static function createType(string $name, ?string $generic, bool $nullable = false): Type
    {
        $typeName = $name;
        $class = null;

        if (class_exists($name) || interface_exists($name)) {
            $typeName = 'object';
            $class = $name;
        }

        return new Type(TypeName::from($typeName), $class, $generic, $nullable);
    }

    /**
     * @param class-string $class
     * @return array<string, Property>
     */
    public static function mapProperties(string $class): array
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

            $description = self::findDescription($property);

            $type = $property->getType();

            if (! $type instanceof \ReflectionNamedType) {
                throw new \LogicException(sprintf('Property %s::%s not has type', $class, $property->getName()));
            }

            $map[$property->getName()] = new Property(
                $property->getName(),
                self::createType($type->getName(), $generic, $type->allowsNull()),
                $description?->description ?? '',
            );
        }

        return $map;
    }

    public static function findDescription(\ReflectionParameter|\ReflectionProperty $reflector): ?Description
    {
        $attributes = $reflector->getAttributes(Description::class);

        return count($attributes) > 0 ? $attributes[0]->newInstance() : null;
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

        return ClassSummary::findInPhpDocComment($comment);
    }

    /**
     * @param class-string $class
     */
    public static function canConstructWithoutParameters(string $class): bool
    {
        $reflector = new \ReflectionClass($class);

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return true;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return true;
        }

        foreach ($constructor->getParameters() as $parameter) {
            if ($parameter->allowsNull()) {
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                continue;
            }

            $type = $parameter->getType();

            if (! $type instanceof \ReflectionNamedType) {
                continue;
            }

            if (class_exists($type->getName()) && self::canConstructWithoutParameters($type->getName())) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * @param class-string<\BackedEnum> $enum
     * @return string
     */
    public static function valueTypeForEnum(string $enum): string
    {
        $reflector = new \ReflectionEnum($enum);

        $type = $reflector->getBackingType();

        return $type instanceof \ReflectionNamedType ? $type->getName() : '';
    }
}
