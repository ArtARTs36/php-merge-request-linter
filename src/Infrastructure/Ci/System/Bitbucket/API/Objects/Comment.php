<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

/**
 * @codeCoverageIgnore
 */
class Comment
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly string $content,
        public readonly string $authorAccountId,
    ) {
        //
    }
}
