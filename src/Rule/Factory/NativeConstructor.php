<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class NativeConstructor implements RuleConstructor
{
    public function __construct(
        private \ReflectionMethod $constructor,
    ) {
    }

    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->constructor);
    }

    public function construct(array $args): Rule
    {
        //@phpstan-ignore-next-line
        return $this->constructor->getDeclaringClass()->newInstanceArgs($args);
    }
}
