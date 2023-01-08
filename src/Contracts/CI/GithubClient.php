<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagsInput;

/**
 * Client for GitHub.
 */
interface GithubClient
{
    /**
     * Get Pull Request.
     */
    public function getPullRequest(PullRequestInput $input): PullRequest;

    /**
     * Get tags from repository.
     */
    public function getTags(TagsInput $input): TagCollection;
}
