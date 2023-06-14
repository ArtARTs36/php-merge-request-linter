<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

/**
 * @codeCoverageIgnore
 */
class Comment
{
    public function __construct(
        public readonly string $id,
        public readonly string $authorLogin,
        public readonly string $message,
    ) {
        //
    }
}
