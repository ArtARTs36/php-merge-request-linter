<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Domain\Request\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;

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
