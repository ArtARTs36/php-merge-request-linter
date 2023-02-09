<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

class StaticConstructor implements RuleConstructor
{
    /**
     * @param class-string $class
     */
    public function __construct(
        private \ReflectionMethod $constructor,
        private string $class,
    ) {
        //
    }

    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->constructor);
    }

    public function construct(array $args): Rule
    {
        $class = $this->class;
        $method = $this->constructor->getName();

        return call_user_func_array($class::$method(...), $args);
    }
}
