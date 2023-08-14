<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\GraphqlException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;

/**
 * Client for GitHub.
 */
interface GithubClient
{
    /**
     * Get Pull Request.
     * @throws RequestException
     * @throws GraphqlException
     */
    public function getPullRequest(PullRequestInput $input): PullRequest;

    /**
     * Get tags from repository.
     * @throws RequestException
     * @throws GraphqlException
     */
    public function getTags(TagsInput $input): TagCollection;

    /**
     * Post comment.
     * @throws RequestException
     * @throws InvalidResponseException
     * @throws GraphqlException
     */
    public function postComment(AddCommentInput $input): string;

    /**
     * Update comment.
     * @throws RequestException
     * @throws GraphqlException
     */
    public function updateComment(UpdateCommentInput $input): void;

    /**
     * Get current user.
     * @throws RequestException
     * @throws InvalidResponseException
     * @throws GraphqlException
     */
    public function getCurrentUser(string $graphqlUrl): Viewer;

    /**
     * Get comments on pull request.
     * @throws RequestException
     * @throws GraphqlException
     */
    public function getCommentsOnPullRequest(string $graphqlUrl, string $requestUri, ?string $after = null): CommentList;
}
