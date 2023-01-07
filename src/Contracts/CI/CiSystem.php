<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Continuous Integration System
 * @internal
 */
interface CiSystem
{
    /**
     * Is currently CiSystem
     */
    public static function is(Environment $environment): bool;

    /**
     * Is Merge Request
     */
    public function isMergeRequest(): bool;

    /**
     * Get current merge request
     * @throws InvalidCredentialsException
     * @throws ServerUnexpectedResponseException
     */
    public function getCurrentlyMergeRequest(): MergeRequest;
}
