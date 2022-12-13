<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

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
