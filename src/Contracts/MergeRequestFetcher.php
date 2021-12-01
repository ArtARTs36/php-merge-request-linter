<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use OndraM\CiDetector\Ci\CiInterface;

/**
 * Fetch merge request of CI
 */
interface MergeRequestFetcher
{
    /**
     * Fetch merge request of CI
     */
    public function fetch(CiInterface $ci): MergeRequest;
}
