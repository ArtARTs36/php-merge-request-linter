<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

class CommentList
{
    public function __construct(
        public readonly Arrayee $comments,
        public readonly int $page,
    ) {
        //
    }
}
