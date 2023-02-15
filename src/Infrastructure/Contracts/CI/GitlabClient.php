<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;

/**
 * Interface for GitLab Client.
 */
interface GitlabClient
{
    /**
     * Get Merge Request.
     */
    public function getMergeRequest(MergeRequestInput $input): MergeRequest;
}
