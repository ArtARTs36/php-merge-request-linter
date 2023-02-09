<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Contracts\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

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
