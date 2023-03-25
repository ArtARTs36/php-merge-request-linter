<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class GivenInvalidPullRequestDataException extends MergeRequestLinterException
{
    public static function keyNotFound(string $key): self
    {
        return new self(sprintf('Key "%s" not found in response', $key));
    }
}
