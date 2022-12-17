<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class Builder
{
    /**
     * @param array<string, ArgResolver> $argResolvers
     */
    public function __construct(
        private array $argResolvers,
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
            $args[$paramName] = $this->argResolvers[$paramType->name]->resolve($params[$paramName]);
        }

        return $args;
    }
}
