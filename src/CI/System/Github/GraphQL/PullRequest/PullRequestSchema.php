<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest;

class PullRequestSchema
{
    /**
     * @param array<string, mixed> $pullRequest
     */
    public function createPullRequest(array $pullRequest): PullRequest
    {
        $pullRequest = $pullRequest['data']['repository']['pullRequest'];

        return new PullRequest(
            $pullRequest['title'],
            $pullRequest['bodyText'],
            array_map(fn (array $item) => $item['name'], $pullRequest['labels']['nodes']),
            $pullRequest['mergeable'],
            $pullRequest['headRefName'],
            $pullRequest['baseRefName'],
            $pullRequest['author']['login'],
            $pullRequest['isDraft'] ?? false,
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
      isDraft
    }
  }
}";
    }
}
