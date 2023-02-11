<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;

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
