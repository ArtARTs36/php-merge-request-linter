<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Interface for request fetching.
 */
interface MergeRequestFetcher
{
    /**
     * Fetch Merge Request.
     * @throws CurrentlyNotMergeRequestException
     */
    public function fetch(): MergeRequest;
}
