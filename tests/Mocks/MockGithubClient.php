<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\ToolInfo\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

final class MockGithubClient implements GithubClient
{
    /**
     * @param array<Tag> $tags
     */
    public function __construct(
        private array $tags = [],
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        // TODO: Implement getPullRequest() method.
    }

    public function getTags(TagsInput $input): TagCollection
    {
        return new TagCollection($this->tags);
    }

    public function postComment(AddCommentInput $input): string
    {
        // TODO: Implement postComment() method.
    }

    public function updateComment(UpdateCommentInput $input): void
    {
        // TODO: Implement updateComment() method.
    }

    public function getCurrentUser(string $graphqlUrl): Viewer
    {
        // TODO: Implement getCurrentUser() method.
    }

    public function getCommentsOnPullRequest(string $graphqlUrl, string $requestUri): Arrayee
    {
        // TODO: Implement getCommentsOnPullRequest() method.
    }
}
