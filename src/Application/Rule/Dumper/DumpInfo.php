<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

class DumpInfo
{
    /**
     * @param array<RuleInfo> $infos
     */
    public function __construct(
        public readonly string $configPath,
        public readonly array $infos,
    ) {
        //
    }
}
