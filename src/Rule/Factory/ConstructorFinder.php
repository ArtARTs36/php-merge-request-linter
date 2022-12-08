<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class ConstructorFinder
{
    private const MAKE_METHOD = 'make';

    /**
     * @param class-string<Rule> $class
     * @throws \ReflectionException
     */
    public function find(string $class): RuleConstructor
    {
        $reflector = new \ReflectionClass($class);

        if ($reflector->hasMethod(static::MAKE_METHOD)) {
            return new StaticConstructor($reflector->getMethod(static::MAKE_METHOD), $reflector->getName());
        }

        return new NativeConstructor($reflector->getConstructor());
    }
}
