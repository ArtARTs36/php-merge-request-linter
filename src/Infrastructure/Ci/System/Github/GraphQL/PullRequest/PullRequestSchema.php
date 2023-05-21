<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GivenInvalidPullRequestDataException;

class PullRequestSchema
{
    /**
     * @param array<string, mixed> $pullRequest
     * @throws \Exception
     */
    public function createPullRequest(array $pullRequest): PullRequest
    {
        if (! array_key_exists('data', $pullRequest) || ! is_array($pullRequest['data'])) {
            throw GivenInvalidPullRequestDataException::keyNotFound('data');
        }

        if (! array_key_exists('repository', $pullRequest['data']) || ! is_array($pullRequest['data']['repository'])) {
            throw GivenInvalidPullRequestDataException::keyNotFound('data.repository');
        }

        if (! array_key_exists('pullRequest', $pullRequest['data']['repository']) || ! is_array($pullRequest['data']['repository']['pullRequest'])) {
            throw GivenInvalidPullRequestDataException::keyNotFound('data.repository.pullRequest');
        }

        $pullRequest = $pullRequest['data']['repository']['pullRequest'];

        return new PullRequest(
            $pullRequest['title'],
            $pullRequest['body'],
            $pullRequest['bodyText'],
            array_map(fn (array $item) => $item['name'], $pullRequest['labels']['nodes'] ?? []),
            $pullRequest['mergeable'],
            $pullRequest['headRefName'],
            $pullRequest['baseRefName'],
            $pullRequest['changedFiles'],
            $pullRequest['author']['login'],
            $pullRequest['isDraft'] ?? false,
            new \DateTimeImmutable($pullRequest['createdAt']),
            $pullRequest['url'],
        );
    }

    public function createQuery(PullRequestInput $input): string
    {
        return "query { 
  repository(owner: \"$input->owner\", name: \"$input->repository\") {
    pullRequest(number: $input->requestId) {
      author {
        login
      }
      title
      body
      bodyText
      mergeable
      baseRefName
      headRefName
      labels(first: 100) {
        totalCount
        nodes {
          name
        }
      }
      changedFiles
      isDraft
      createdAt
      url
    }
  }
}";
    }
}
