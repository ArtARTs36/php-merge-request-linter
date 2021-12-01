<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;
use OndraM\CiDetector\Ci\CiInterface;

final class EmptyMergeRequestFetcher implements MergeRequestFetcher
{
    public function fetch(CiInterface $ci): MergeRequest
    {
        return new MergeRequest(Str::fromEmpty(), Str::fromEmpty(), new Map([]), false);
    }
}
