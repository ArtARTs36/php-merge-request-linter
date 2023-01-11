<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

class NativeConstructor implements RuleConstructor
{
    /**
     * @param \ReflectionClass<object> $classReflector
     * @param \ReflectionMethod $methodReflector
     */
    public function __construct(
        private \ReflectionClass $classReflector,
        private \ReflectionMethod $methodReflector,
    ) {
        //
    }

    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->methodReflector);
    }

    public function construct(array $args): Rule
    {
        /** @var class-string<Rule> $class */
        $class = $this->classReflector->getName();

        return new $class(...$args);
    }
}
