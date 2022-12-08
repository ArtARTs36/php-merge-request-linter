<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class Reflector
{
    /**
     * @return array<string, string|class-string>
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

            $params[$parameter->getName()] = $type->getName();
        }

        return $params;
    }
}
