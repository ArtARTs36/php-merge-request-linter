<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

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

        foreach ($constructor->getParameters() as $property) {
            if (isset($params[$property->name])) {
                $paramsArray[$position] = $params[$property->name];
            } elseif ($property->getType() !== null && $property->getType()->allowsNull()) {
                $params[$property->name] = null;
                $paramsArray[$position] = null;
            }

            ++$position;
        }

        return $paramsArray;
    }
}
