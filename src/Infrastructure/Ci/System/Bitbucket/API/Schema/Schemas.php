<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

/**
 * @codeCoverageIgnore
 */
class Schemas
{
    public function __construct(
        public readonly CreateCommentSchema $commentCreate = new CreateCommentSchema(),
        public readonly GetCommentsSchema $commentsGet = new GetCommentsSchema(),
        public readonly GetCurrentUserSchema $userGetCurrent = new GetCurrentUserSchema(),
    ) {
        //
    }
}
