<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Tasks;

/**
 * @codeCoverageIgnore
 */
readonly class DumpTask
{
    public function __construct(
        public string  $workingDirectory,
        public ?string $customConfigPath,
    ) {
    }
}
