<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

/**
 * @codeCoverageIgnore
 */
class AddedComment
{
    public function __construct(
        public readonly string $id,
    ) {
        //
    }
}
