<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequestInput;

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
