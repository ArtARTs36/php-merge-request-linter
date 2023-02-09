<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;

class RuleInfo
{
    /**
     * @param class-string<Rule> $class
     */
    public function __construct(
        public readonly string $definition,
        public readonly string $class,
    ) {
        //
    }
}
