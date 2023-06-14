<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment\CreatedComment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Query\Query;

class AddCommentSchema
{
    private const QUERY = 'mutation CreateComment ($requestId: ID!, $message: String!) {
  addComment(input: {subjectId: $requestId, body: $message}) {
    commentEdge {
      node {
        id
      }
    }
  }
}';

    public function createMutation(CommentInput $input): Query
    {
        return new Query(
            self::QUERY,
            [
                'requestId' => $input->subjectId,
                'message' => $input->message,
            ],
        );
    }

    public function decodeResponse(string $json): CreatedComment
    {
        $data = json_decode($json, true);

        return new CreatedComment(
            $data['data']['addComment']['commentEdge']['node']['id'] ?? '',
        );
    }
}
