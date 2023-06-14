<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Type\AddedComment;

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

    public function createMutation(AddCommentInput $input): Query
    {
        return new Query(
            self::QUERY,
            [
                'requestId' => $input->subjectId,
                'message' => $input->message,
            ],
        );
    }

    public function decodeResponse(string $json): AddedComment
    {
        $data = json_decode($json, true);

        return new AddedComment(
            $data['data']['addComment']['commentEdge']['node']['id'] ?? '',
        );
    }
}
