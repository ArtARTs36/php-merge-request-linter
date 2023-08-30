<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

/**
 * @codeCoverageIgnore
 */
readonly class Comment
{
    public function __construct(
        public string $id,
        public string $authorLogin,
        public string $message,
    ) {
        //
    }
}
