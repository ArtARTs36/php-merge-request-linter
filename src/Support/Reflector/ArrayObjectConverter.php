<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

class ArrayObjectConverter
{
    /**
     * @template T
     * @param array<string, mixed> $data
     * @param class-string<T> $class
     * @return object<T>
     */
    public function convert(array $data, string $class): object
    {
        $reflector = new \ReflectionClass($class);
        $params = $data;

        foreach ($reflector->getProperties() as $property) {
            if (isset($params[$property->name])) {
                continue;
            }

            if ($property->getType()->allowsNull()) {
                $params[$property->name] = null;
            }
        }

        return $reflector->newInstanceArgs($params);
    }
}
