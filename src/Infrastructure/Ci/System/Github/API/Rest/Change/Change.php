<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;

/**
 * @codeCoverageIgnore
 */
readonly class Change
{
    public function __construct(
        public string $filename,
        public Diff   $diff,
        public Status $status,
    ) {
    }
}
