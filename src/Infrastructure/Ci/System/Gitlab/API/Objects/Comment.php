<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

/**
 * @codeCoverageIgnore
 */
class Comment
{
    public function __construct(
        public readonly int $id,
        public readonly string $body,
        public readonly string $authorLogin,
    ) {
        //
    }
}
