<?php

namespace ArtARTs36\MergeRequestLinter\Request\Fetcher;

use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class MemoryRequestFetcher implements MergeRequestFetcher
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

    public function useRequest(MergeRequest $request): void
    {
        $this->request = $request;
    }
}
