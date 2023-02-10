<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

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
