<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class CreateCommentSchema
{
    /**
     * @param array<mixed> $data
     */
    public function createResponse(array $data): Comment
    {
        $raw = new RawArray($data);

        return new Comment(
            $raw->int('id'),
            $raw->string('links.self.href'),
            $raw->string('content.raw'),
            $raw->string('user.account_id'),
        );
    }
}
