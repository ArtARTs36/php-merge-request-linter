<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Schema;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class GithubPullRequestSchema
{
    protected const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';

    /**
     * @param array<string, mixed> $pullRequest
     */
    public function createMergeRequest(array $pullRequest): MergeRequest
    {
        return MergeRequest::fromArray([
            'title' => $pullRequest['title'],
            'description' => $pullRequest['bodyText'],
            'labels' => array_map(fn (array $item) => $item['name'], $pullRequest['labels']['nodes']),
            'has_conflicts' => $pullRequest['mergeable'] !== self::MERGEABLE_STATE_CONFLICTING,
            'source_branch' => $pullRequest['headRefName'],
            'target_branch' => $pullRequest['baseRefName'],
            'changed_files_count' => $pullRequest['changedFiles'],
            'author_login' => $pullRequest['author']['login'],
        ]);
    }

    public function createGraphqlForPullRequest(string $owner, string $repo, int $requestId): string
    {
        return "query { 
  repository(owner: \"$owner\", name: \"$repo\") {
    pullRequest(number: $requestId) {
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
      changedFiles
    }
  }
}";
    }
}
