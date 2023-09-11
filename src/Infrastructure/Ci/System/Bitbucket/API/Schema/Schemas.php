<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

/**
 * @codeCoverageIgnore
 */
readonly class Schemas
{
    public function __construct(
        public CreateCommentSchema  $commentCreate = new CreateCommentSchema(),
        public GetCommentsSchema    $commentsGet = new GetCommentsSchema(),
        public GetCurrentUserSchema $userGetCurrent = new GetCurrentUserSchema(),
    ) {
    }
}
