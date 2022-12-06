<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class RuleFactory
{
    private const MAKE_METHOD = 'make';

    /**
     * @param array<string, ArgResolver> $argResolvers
     */
    public function __construct(
        private array $argResolvers,
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

        return $constructor->construct($this->buildArgs($constructor, $params));
    }

    private function buildArgs(RuleConstructor $constructor, array $params): array
    {
        $args = [];

        foreach ($constructor->params() as $paramName => $paramType) {
            $args[$paramName] = $this->argResolvers[$paramType]->resolve($params[$paramName]);
        }

        return $args;
    }

    private function getConstructor(\ReflectionClass $reflector): RuleConstructor
    {
        if ($reflector->hasMethod(static::MAKE_METHOD)) {
            return new StaticConstructor($reflector->getMethod(static::MAKE_METHOD));
        }

        return new NativeConstructor($reflector->getConstructor());
    }
}
