<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;

/**
 * Interface for GitLab Client.
 */
interface GitlabClient
{
    /**
     * Get Merge Request.
     */
    public function getMergeRequest(MergeRequestInput $input): MergeRequest;

    public function postComment(CommentInput $input): void;
}
