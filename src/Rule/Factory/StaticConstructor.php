<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class StaticConstructor implements RuleConstructor
{
    public function __construct(
        private \ReflectionMethod $constructor,
    ) {
        //
    }

    /**
     * @return array<string, string|class-string>
     */
    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->constructor);
    }

    public function construct(array $args): Rule
    {
        $class = $this->constructor->getDeclaringClass()->getName();
        $method = $this->constructor->getName();

        return $class::$method();
    }
}
