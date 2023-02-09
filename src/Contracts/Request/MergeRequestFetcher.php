<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;

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
