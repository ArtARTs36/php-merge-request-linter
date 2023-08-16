<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\ToolInfo\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\CommentList;
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
        private ?Viewer $user = null,
        private ?CommentList $comments = null,
        private PullRequest|\Throwable|null $getPullRequestResposne = null,
        private ?\Throwable $updateCommentResponse = null,
        private ?\Throwable $postCommentOnMergeRequestResponse = null,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        if ($this->getPullRequestResposne === null) {
            throw new \Exception('Response not defined');
        }

        if ($this->getPullRequestResposne instanceof PullRequest) {
            return $this->getPullRequestResposne;
        }

        throw $this->getPullRequestResposne;
    }

    public function getTags(TagsInput $input): TagCollection
    {
        return new TagCollection($this->tags);
    }

    public function postComment(AddCommentInput $input): string
    {
        if ($this->postCommentOnMergeRequestResponse instanceof \Exception) {
            throw $this->postCommentOnMergeRequestResponse;
        }

        return '1';
    }

    public function updateComment(UpdateCommentInput $input): void
    {
        if ($this->updateCommentResponse instanceof \Exception) {
            throw $this->updateCommentResponse;
        }
    }

    public function getCurrentUser(string $graphqlUrl): Viewer
    {
        return $this->user;
    }

    public function getCommentsOnPullRequest(string $graphqlUrl, string $requestUri, ?string $after = null): CommentList
    {
        return $this->comments;
    }
}
