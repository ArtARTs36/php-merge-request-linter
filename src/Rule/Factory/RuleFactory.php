<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;

class RuleFactory
{
    public function __construct(
        private Builder $argBuilder,
        private ConstructorFinder $constructor,
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
