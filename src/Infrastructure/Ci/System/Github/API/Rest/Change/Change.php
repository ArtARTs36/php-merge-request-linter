<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;

/**
 * @codeCoverageIgnore
 */
class Change
{
    /**
     * @param array<DiffLine> $diff
     */
    public function __construct(
        public readonly string $filename,
        public readonly array $diff,
        public readonly Status $status,
    ) {
        //
    }
}
