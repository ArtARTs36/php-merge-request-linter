<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

class Reflector
{
    /**
     * @return array<string, string|class-string>
     */
    public static function mapMethodParamTypeOnParam(\ReflectionMethod $method): array
    {
        $params = [];

        foreach ($method->getParameters() as $parameter) {
            $params[$parameter->getName()] = $parameter->getType()->getName();
        }

        return $params;
    }
}
