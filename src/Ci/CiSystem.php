<?php

namespace ArtARTs36\MergeRequestLinter\Ci;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface CiSystem
{
    /**
     * Get current merge request
     */
    public function getMergeRequest(): MergeRequest;
}
