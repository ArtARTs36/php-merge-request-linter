<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

/**
 * @codeCoverageIgnore
 */
readonly class Comment
{
    public function __construct(
        public int    $id,
        public string $body,
        public string $authorLogin,
    ) {
        //
    }
}
