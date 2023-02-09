<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;

class Change
{
    /**
     * @param array<DiffLine> $diff
     */
    public function __construct(
        public readonly string $newPath,
        public readonly string $oldPath,
        public readonly array $diff,
    ) {
        //
    }
}
