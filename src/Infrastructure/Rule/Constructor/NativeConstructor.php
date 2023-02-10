<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

class NativeConstructor implements RuleConstructor
{
    /**
     * @param \ReflectionClass<object> $classReflector
     */
    public function __construct(
        private \ReflectionClass  $classReflector,
        private \ReflectionMethod $constructorReflector,
    ) {
        //
    }

    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->constructorReflector);
    }

    public function construct(array $args): Rule
    {
        /** @var class-string<Rule> $class */
        $class = $this->classReflector->getName();

        return new $class(...$args);
    }
}
