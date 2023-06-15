<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arr;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

class GetCommentsSchema
{
    private const QUERY = 'query GetCommentsForPullRequest($url: URI!) {
  resource(url: $url) {
    ... on PullRequest {
      comments(first: 10) {
        nodes {
          id
          author {
            login
          }
          body
        }
        pageInfo {
          hasNextPage
        }
      }
    }
  }
}';

    public function createQuery(string $pullRequestUrl): Query
    {
        return new Query(self::QUERY, [
            'url' => $pullRequestUrl,
        ]);
    }

    /**
     * @param array<string, mixed> $response
     * @return Arrayee<int, Comment>
     */
    public function createComments(array $response): Arrayee
    {
        $comments = [];

        foreach (Arr::path($response, 'data.resource.comments.nodes') as $comment) {
            $comments[] = new Comment(
                $comment['id'],
                $comment['author']['login'],
                $comment['body'],
            );
        }

        return new Arrayee($comments);
    }
}
