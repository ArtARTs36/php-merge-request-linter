<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

class ArrayObjectConverter
{
    /**
     * @param array<string, mixed> $data
     * @param class-string $class
     */
    public function convert(array $data, string $class): object
    {
        $reflector = new \ReflectionClass($class);
        $params = $this->mapParams($reflector, $data);

        return $reflector->newInstanceArgs($params);
    }

    /**
     * Map object param values.
     * @param \ReflectionClass<object> $reflector
     * @param array<string, mixed> $data
     * @return array<int, mixed>
     */
    private function mapParams(\ReflectionClass $reflector, array $data): array
    {
        $paramsArray = [];
        $params = $data;

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return [];
        }

        $position = 0;

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            $typeName = $type instanceof \ReflectionNamedType ? $type->getName() : null;

            if (isset($params[$parameter->name])) {
                if ($typeName !== null && enum_exists($typeName)) {
                    /** @var class-string<\BackedEnum> $enum */
                    $enum = $typeName;

                    $params[$parameter->name] = $this->createEnum($enum, $params[$parameter->name]);
                }
            } else {
                if ($parameter->isDefaultValueAvailable()) {
                    $params[$parameter->name] = $parameter->getDefaultValue();
                } elseif ($type !== null && $type->allowsNull()) {
                    $params[$parameter->name] = null;
                } elseif ($typeName && class_exists($typeName) && Reflector::canConstructWithoutParameters($typeName)) {
                    $params[$parameter->name] = $this->convert([], $typeName);
                }
            }

            $paramsArray[$position] = $params[$parameter->name];

            ++$position;
        }

        return $paramsArray;
    }

    /**
     * @param class-string<\BackedEnum> $enum
     * @throws \Exception
     */
    private function createEnum(string $enum, mixed $value): \BackedEnum
    {
        if (! is_string($value) && ! is_int($value)) {
            throw new \Exception(sprintf(
                'Value for enum %s must be %s',
                $enum,
                is_subclass_of($enum, 'IntBackedEnum') ? 'int' : 'string',
            ));
        }

        return $enum::from($value);
    }
}
