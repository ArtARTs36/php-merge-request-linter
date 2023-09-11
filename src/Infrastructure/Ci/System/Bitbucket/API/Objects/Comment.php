<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

/**
 * @codeCoverageIgnore
 */
readonly class Comment
{
    public function __construct(
        public int    $id,
        public string $url,
        public string $content,
        public string $authorAccountId,
    ) {
    }
}
