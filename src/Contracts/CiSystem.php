<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface CiSystem
{
    /**
     * Get current merge request
     * @throws InvalidCredentialsException
     */
    public function getMergeRequest(): MergeRequest;
}
