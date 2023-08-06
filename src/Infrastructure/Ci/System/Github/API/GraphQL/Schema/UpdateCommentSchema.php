<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class UpdateCommentSchema
{
    private const QUERY = 'mutation UpdatePullRequestComment($commentId: ID!, $body: String!) {
  updateIssueComment(input: { id: $commentId, body: $body }) {
    issueComment {
      id
    }
  }
}';

    public function createQuery(UpdateCommentInput $input): Query
    {
        return new Query(self::QUERY, [
            'commentId' => $input->commentId,
            'body' => $input->message,
        ]);
    }

    /**
     * @param array<mixed> $response
     */
    public function check(array $response, string $commentId): bool
    {
        return (new RawArray($response))->string('data.updateIssueComment.issueComment.id') === $commentId;
    }
}
