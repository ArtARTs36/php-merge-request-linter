<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

/**
 * @codeCoverageIgnore
 */
class RuleInfo
{
    public function __construct(
        public readonly string $name,
        public readonly string $definition,
        public readonly bool $critical = true,
    ) {
        //
    }
}
