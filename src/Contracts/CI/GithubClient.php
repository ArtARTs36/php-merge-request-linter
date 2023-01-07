<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;

/**
 * Client for GitHub.
 */
interface GithubClient
{
    /**
     * Get Pull Request.
     */
    public function getPullRequest(PullRequestInput $input): PullRequest;
}
