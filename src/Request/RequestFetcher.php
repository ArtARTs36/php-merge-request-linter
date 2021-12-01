<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use OndraM\CiDetector\Ci\CiInterface;

class RequestFetcher
{
    public function __construct(protected SystemFactory $systems)
    {
        //
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function fetch(CiInterface $ci): MergeRequest
    {
        return $this->systems->create($ci->getCiName())->getMergeRequest();
    }
}
