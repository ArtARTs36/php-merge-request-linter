<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;

class RuleFactory
{
    private const MAKE_METHOD = 'make';

    public function __construct(
        private Builder $argBuilder,
    ) {
        //
    }

    /**
     * @param class-string<Rule> $class
     * @param array<string, mixed> $params
     */
    public function create(string $class, array $params): Rule
    {
        $reflector = new \ReflectionClass($class);
        $constructor = $this->getConstructor($reflector);

        return $constructor->construct($this->argBuilder->build($constructor, $params));
    }

    private function getConstructor(\ReflectionClass $reflector): RuleConstructor
    {
        if ($reflector->hasMethod(static::MAKE_METHOD)) {
            return new StaticConstructor($reflector->getMethod(static::MAKE_METHOD));
        }

        return new NativeConstructor($reflector->getConstructor());
    }
}
