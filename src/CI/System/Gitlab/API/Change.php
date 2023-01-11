<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Line;

class Change
{
    /**
     * @param array<Line> $diff
     */
    public function __construct(
        public readonly string $newPath,
        public readonly string $oldPath,
        public readonly array $diff,
    ) {
        //
    }
}
