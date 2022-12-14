<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;

class CiMergeRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private CiSystemFactory $systems,
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
