<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator\Instantiator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

/**
 * @phpstan-import-type ArgumentValue from ArgumentResolver
 */
class Builder
{
    public function __construct(
        private readonly ArgumentResolver $argResolver,
    ) {
        //
    }

    /**
     * @param Instantiator<Rule> $constructor
     * @param array<string, ArgumentValue> $params
     * @return array<string, mixed>
     */
    public function build(Instantiator $constructor, array $params): array
    {
        $args = [];

        foreach ($constructor->params() as $paramName => $paramType) {
            $args[$paramName] = $this->argResolver->resolve($paramType, $params[$paramName] ?? null);
        }

        return $args;
    }
}
