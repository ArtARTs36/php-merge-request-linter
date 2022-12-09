<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class ConstructorFinder
{
    private const MAKE_METHOD = 'make';

    /**
     * @param class-string<Rule> $class
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function find(string $class): RuleConstructor
    {
        $reflector = new \ReflectionClass($class);

        if ($reflector->hasMethod(self::MAKE_METHOD)) {
            return new StaticConstructor($reflector->getMethod(self::MAKE_METHOD), $reflector->getName());
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new EmptyConstructor($class);
        }

        return new NativeConstructor($constructor);
    }
}