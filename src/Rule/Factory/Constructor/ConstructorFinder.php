<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Exception\ConstructorFindException;

class ConstructorFinder implements RuleConstructorFinder
{
    private const MAKE_METHOD = 'make';

    /**
     * @param class-string<Rule> $class
     * @throws ConstructorFindException
     */
    public function find(string $class): RuleConstructor
    {
        if (! class_exists($class)) {
            throw new ConstructorFindException(sprintf('Class %s not found', $class));
        }

        $reflector = new \ReflectionClass($class);

        if (! $reflector->implementsInterface(Rule::class)) {
            throw new ConstructorFindException(sprintf('Class %s not implemented %s', $class, Rule::class));
        }

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
