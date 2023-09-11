<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

/**
 * @codeCoverageIgnore
 */
readonly class DumpInfo
{
    /**
     * @param array<RuleInfo> $infos
     */
    public function __construct(
        public string $configPath,
        public array  $infos,
    ) {
    }
}
