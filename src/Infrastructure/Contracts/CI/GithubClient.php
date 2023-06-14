<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagsInput;

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

    public function postCommentOnPullRequest(AddCommentInput $input): string;

    public function getCurrentUser(string $graphqlUrl): Viewer;
}
