<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;

/**
 * @codeCoverageIgnore
 */
class LinterConfig
{
    public function __construct(
        public readonly LinterOptions $options,
    ) {
        //
    }
}
