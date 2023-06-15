<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\CommentList;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayPathInvalidException;

class GetCommentsSchema
{
    private const QUERY = 'query GetCommentsForPullRequest($url: URI!, $after: String) {
  resource(url: $url) {
    ... on PullRequest {
      comments(first: 1, after: $after) {
        nodes {
          id
          author {
            login
          }
          body
        }
        pageInfo {
          endCursor
          hasNextPage
        }
      }
    }
  }
}';

    public function createQuery(string $pullRequestUrl, ?string $after = null): Query
    {
        return new Query(self::QUERY, [
            'url' => $pullRequestUrl,
            'after' => null,
        ]);
    }

    /**
     * @param array<string, mixed> $response
     * @throws InvalidResponseException
     */
    public function createCommentList(array $response): CommentList
    {
        try {
            return $this->doCreateComments($response);
        } catch (ArrayPathInvalidException $e) {
            throw InvalidResponseException::make($e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $response
     * @return Arrayee<int, Comment>
     * @throws ArrayPathInvalidException
     */
    private function doCreateComments(array $response): CommentList
    {
        $raw = new RawArray($response);

        $root = $raw->array('data.resource.comments');

        $comments = [];

        foreach ($root->array('nodes') as $comment) {
            $c = new RawArray($comment);

            $comments[] = new Comment(
                $c->string('id'),
                $c->string('author.login'),
                $c->string('body'),
            );
        }

        $pageInfo = $root->array('pageInfo');

        return new CommentList(
            new Arrayee($comments),
            $pageInfo->bool('hasNextPage'),
            $pageInfo->stringOrNull('endCursor'),
        );
    }
}
