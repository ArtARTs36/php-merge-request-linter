<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use OndraM\CiDetector\Ci\CiInterface;

class RequestFetcher
{
    public function __construct(protected SystemFactory $systems)
    {
        //
    }

    public function fetch(CiInterface $ci): MergeRequest
    {
        return $this->systems->create($ci->getCiName())->getMergeRequest();
    }
}
