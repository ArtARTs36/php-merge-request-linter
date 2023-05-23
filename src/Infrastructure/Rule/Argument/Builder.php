<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator\Instantiator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

class Builder
{
    public function __construct(
        private readonly ArgumentResolver $argResolver,
    ) {
        //
    }

    /**
     * @param Instantiator<Rule> $constructor
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function build(Instantiator $constructor, array $params): array
    {
        $args = [];

        foreach ($constructor->params() as $paramName => $param) {
            $args[$paramName] = $this->argResolver->resolve($param->type, $params[$paramName] ?? null);
        }

        return $args;
    }
}
