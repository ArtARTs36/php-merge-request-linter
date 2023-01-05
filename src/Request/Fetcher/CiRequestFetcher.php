<?php

namespace ArtARTs36\MergeRequestLinter\Request\Fetcher;

use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class CiRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private readonly CiSystemFactory $systems,
    ) {
        //
    }

    public function fetch(): MergeRequest
    {
        $ci = $this->systems->createCurrently();

        if (! $ci->isMergeRequest()) {
            throw new CurrentlyNotMergeRequestException();
        }

        return $ci->getMergeRequest();
    }
}
