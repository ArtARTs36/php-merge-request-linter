<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;

/**
 * @codeCoverageIgnore
 */
class Change
{
    public function __construct(
        public readonly string $newPath,
        public readonly string $oldPath,
        public readonly Diff $diff,
    ) {
        //
    }
}
