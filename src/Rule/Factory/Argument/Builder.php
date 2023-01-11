<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructor;

class Builder
{
    /**
     * @param array<string, ArgumentResolver> $argResolvers
     */
    public function __construct(
        private readonly array $argResolvers,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function build(RuleConstructor $constructor, array $params): array
    {
        $args = [];

        foreach ($constructor->params() as $paramName => $paramType) {
            $args[$paramName] = $this->argResolvers[$paramType->name]->resolve($paramType, $params[$paramName]);
        }

        return $args;
    }
}
