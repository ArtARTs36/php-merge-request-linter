<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;

/**
 * @codeCoverageIgnore
 */
readonly class LinterConfig
{
    public function __construct(
        public LinterOptions $options,
    ) {
        //
    }
}
