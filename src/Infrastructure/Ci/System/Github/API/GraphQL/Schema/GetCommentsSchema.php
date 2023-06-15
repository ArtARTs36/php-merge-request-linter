<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayPathInvalidException;

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
     * @throws InvalidResponseException
     */
    public function createComments(array $response): Arrayee
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
    private function doCreateComments(array $response): Arrayee
    {
        $raw = new RawArray($response);

        $data = $raw->array('data.resource.comments.nodes');

        $comments = [];

        foreach ($data->array as $comment) {
            $c = new RawArray($comment);

            $comments[] = new Comment(
                $c->string('id'),
                $c->string('author.login'),
                $c->string('body'),
            );
        }

        return new Arrayee($comments);
    }
}
