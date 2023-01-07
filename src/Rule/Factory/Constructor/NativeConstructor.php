<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

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
