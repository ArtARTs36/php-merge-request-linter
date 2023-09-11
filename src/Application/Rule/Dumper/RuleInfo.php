<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

/**
 * @codeCoverageIgnore
 */
readonly class RuleInfo
{
    public function __construct(
        public string $name,
        public string $definition,
        public bool   $critical = true,
    ) {
    }
}
