<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class CurrentlyNotMergeRequestException extends MergeRequestLinterException implements GettingMergeRequestException
{
    /**
     * @codeCoverageIgnore
     */
    public static function createFrom(\Throwable $e): self
    {
        return new self(sprintf('Currently is not merge request: %s', $e->getMessage()), previous: $e);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function create(): self
    {
        return new self('Currently is not merge request');
    }
}
