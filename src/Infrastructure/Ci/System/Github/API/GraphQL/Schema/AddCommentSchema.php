<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\AddedComment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

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

    /**
     * @param array<string, mixed> $response
     */
    public function createComment(array $response): AddedComment
    {
        $r = new RawArray($response);

        return new AddedComment(
            $r->string('data.addComment.commentEdge.node.id'),
        );
    }
}
