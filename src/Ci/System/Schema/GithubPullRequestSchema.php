<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Schema;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class GithubPullRequestSchema
{
    protected const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';

    public function createMergeRequest(array $pullRequest): MergeRequest
    {
        return MergeRequest::fromArray([
            'title' => $pullRequest['title'],
            'description' => $pullRequest['bodyText'],
            'labels' => array_map(fn (array $item) => $item['name'], $pullRequest['labels']['nodes']),
            'has_conflicts' => $pullRequest['mergeable'] !== self::MERGEABLE_STATE_CONFLICTING,
        ]);
    }

    public function createGraphqlForPullRequest(string $owner, string $repo, int $requestId): string
    {
        return "query { 
  repository(owner: \"$owner\", name: \"$repo\") {
    pullRequest(number: $requestId) {
      title
      bodyText
      mergeable
      labels(first: 100) {
        totalCount
        nodes {
          name
        }
      }
    }
  }
}";
    }
}
