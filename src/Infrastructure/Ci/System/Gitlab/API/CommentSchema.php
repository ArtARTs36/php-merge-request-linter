<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class CommentSchema
{
    /**
     * @param array<mixed> $response
     */
    public function createComment(array $response): Comment
    {
        $responseArray = new RawArray($response);

        return new Comment(
            $responseArray->int('id'),
            $responseArray->string('body'),
        );
    }
}
