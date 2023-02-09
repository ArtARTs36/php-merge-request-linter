<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Continuous Integration System.
 * @internal
 */
interface CiSystem
{
    /**
     * Get CI System Name.
     */
    public function getName(): string;

    /**
     * Is currently CiSystem.
     */
    public function isCurrentlyWorking(): bool;

    /**
     * Is Merge Request.
     */
    public function isCurrentlyMergeRequest(): bool;

    /**
     * Get current merge request.
     * @throws InvalidCredentialsException
     * @throws ServerUnexpectedResponseException
     * @throws CurrentlyNotMergeRequestException
     */
    public function getCurrentlyMergeRequest(): MergeRequest;
}
