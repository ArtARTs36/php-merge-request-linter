<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Builder;

class RuleFactory
{
    public function __construct(
        private readonly Builder $argBuilder,
        private readonly RuleConstructorFinder $constructor,
    ) {
        //
    }

    /**
     * @param class-string<Rule> $class
     * @param array<string, mixed> $params
     */
    public function create(string $class, array $params): Rule
    {
        $constructor = $this->constructor->find($class);

        return $constructor->construct($this->argBuilder->build($constructor, $params));
    }
}
