<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Change;

use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Line;

class Change
{
    /**
     * @param array<Line> $diff
     */
    public function __construct(
        public readonly string $filename,
        public readonly array $diff,
        public readonly Status $status,
    ) {
        //
    }
}
