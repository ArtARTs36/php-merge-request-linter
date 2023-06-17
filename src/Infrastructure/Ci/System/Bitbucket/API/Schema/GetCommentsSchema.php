<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class GetCommentsSchema
{
    public function createResponse(array $data): CommentList
    {
        $raw = new RawArray($data);
        $comments = [];

        foreach ($raw->array('values') as $item) {
            $itemRaw = new RawArray($item);

            $comments[] = new Comment(
                $itemRaw->int('id'),
                $itemRaw->string('links.self.href'),
                $itemRaw->string('content.raw'),
                $itemRaw->string('user.account_id'),
            );
        }

        return new CommentList(
            new Arrayee($comments),
            $raw->int('page'),
        );
    }
}
