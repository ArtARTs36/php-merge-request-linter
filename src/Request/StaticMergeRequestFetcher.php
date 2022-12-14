<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;

class StaticMergeRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private MergeRequest $request,
    ) {
        //
    }

    public function fetch(): MergeRequest
    {
        return $this->request;
    }
}
