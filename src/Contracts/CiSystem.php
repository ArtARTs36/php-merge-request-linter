<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface CiSystem
{
    /**
     * Get current merge request
     */
    public function getMergeRequest(): MergeRequest;
}
