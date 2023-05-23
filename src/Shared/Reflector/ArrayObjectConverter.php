<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflector;

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

            if (! isset($params[$parameter->name])) {
                if ($parameter->isDefaultValueAvailable()) {
                    $params[$parameter->name] = $parameter->getDefaultValue();
                } elseif ($type !== null && $type->allowsNull()) {
                    $params[$parameter->name] = null;
                } elseif ($type !== null && class_exists($type) && Reflector::canConstructWithoutParameters($type->getName())) {
                    $params[$parameter->name] = $this->convert([], $type->getName());
                }
            }

            $paramsArray[$position] = $params[$parameter->name];

            ++$position;
        }

        return $paramsArray;
    }
}
