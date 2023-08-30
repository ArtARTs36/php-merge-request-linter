<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;

/**
 * @codeCoverageIgnore
 */
readonly class Change
{
    public function __construct(
        public string $newPath,
        public string $oldPath,
        public Diff   $diff,
    ) {
        //
    }
}
