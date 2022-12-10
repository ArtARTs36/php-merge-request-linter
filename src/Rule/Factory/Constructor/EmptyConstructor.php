<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;

class EmptyConstructor implements RuleConstructor
{
    /**
     * @param class-string<Rule> $class
     */
    public function __construct(
        private string $class,
    ) {
        //
    }

    public function params(): array
    {
        return [];
    }

    public function construct(array $args): Rule
    {
        $class = $this->class;

        return new $class();
    }
}
