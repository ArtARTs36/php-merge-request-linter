<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Tasks;

/**
 * @codeCoverageIgnore
 */
class DumpTask
{
    public function __construct(
        public readonly string  $workingDirectory,
        public readonly ?string $customConfigPath,
    ) {
        //
    }
}
