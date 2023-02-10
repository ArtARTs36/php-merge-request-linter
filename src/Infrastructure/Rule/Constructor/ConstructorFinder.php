<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ConstructorFindException;

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

        return new NativeConstructor($reflector, $constructor);
    }
}
