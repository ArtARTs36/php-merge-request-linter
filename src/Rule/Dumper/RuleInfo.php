<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Dumper;

class RuleInfo
{
    public function __construct(
        public readonly string $definition,
        public readonly string $class,
    ) {
        //
    }
}
