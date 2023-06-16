<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CreatedComment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class CreateCommentSchema
{
    public function createResponse(array $data): CreatedComment
    {
        $raw = new RawArray($data);

        return new CreatedComment(
            $raw->int('id'),
            $raw->string('links.self.href'),
        );
    }
}
