<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructor;

class Builder
{
    public function __construct(
        private readonly ArgumentResolver $argResolver,
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
            $args[$paramName] = $this->argResolver->resolve($paramType, $params[$paramName] ?? null);
        }

        return $args;
    }
}
