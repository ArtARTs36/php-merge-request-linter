<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest;

use ArtARTs36\Normalizer\Contracts\Denormalizer;

class PullRequestSchema
{
    public function __construct(
        private readonly Denormalizer $denormalizer,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $pullRequest
     */
    public function createPullRequest(array $pullRequest): PullRequest
    {
        return $this
            ->denormalizer
            ->denormalize(PullRequest::class, $pullRequest['data']['repository']['pullRequest'] ?? []);
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
