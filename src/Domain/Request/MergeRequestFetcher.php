<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Domain\CI\GettingMergeRequestException;

/**
 * Interface for request fetching.
 */
interface MergeRequestFetcher
{
    /**
     * Fetch Merge Request.
     * @throws GettingMergeRequestException
     */
    public function fetch(): MergeRequest;
}
