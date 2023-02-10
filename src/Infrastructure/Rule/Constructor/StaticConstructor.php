<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Common\Reflector\Reflector;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructor;

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
