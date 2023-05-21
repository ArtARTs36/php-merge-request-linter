<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator\InstantiatorFinder;

class RuleFactory
{
    public function __construct(
        private readonly Builder            $argBuilder,
        private readonly InstantiatorFinder $constructor,
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

        return $constructor->instantiate($this->argBuilder->build($constructor, $params));
    }
}
