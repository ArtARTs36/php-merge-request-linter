<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Continuous Integration System
 */
interface CiSystem
{
    /**
     * Get current merge request
     * @throws InvalidCredentialsException
     */
    public function getMergeRequest(): MergeRequest;
}
