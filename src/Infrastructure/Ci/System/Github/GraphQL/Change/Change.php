<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;

/**
 * @codeCoverageIgnore
 */
class Change
{
    public function __construct(
        public readonly string $filename,
        public readonly Diff $diff,
        public readonly Status $status,
    ) {
        //
    }
}
