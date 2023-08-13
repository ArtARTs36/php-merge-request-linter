<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

final class MergeRequestNotFoundException extends MergeRequestLinterException implements GettingMergeRequestException
{
    /**
     * @codeCoverageIgnore
     */
    public static function create(string $id, string $reason, ?\Throwable $previous = null): self
    {
        return new self(
            sprintf('Merge request with id %s not found: %s', $id, $reason),
            previous: $previous,
        );
    }
}
