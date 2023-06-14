<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Comment\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Type\Viewer;

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

    public function postCommentOnPullRequest(CommentInput $input): string;

    public function getCurrentUser(string $graphqlUrl): Viewer;
}
