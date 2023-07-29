<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class GivenInvalidPullRequestDataException extends MergeRequestLinterException
{
    public function __construct(
        string $message,
        private readonly bool $isInvalidRootKey,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function keyNotFound(string $key, bool $isRootKey = false): self
    {
        return new self(sprintf('Key "%s" not found in response', $key), $isRootKey);
    }

    public static function invalidType(
        string $key,
        string $expectedType,
        ?\Throwable $previous = null,
        bool $isRootKey = false,
    ): self {
        return new self(
            sprintf('Value of key "%s" has invalid type. Expected type: %s', $key, $expectedType),
            $isRootKey,
            previous: $previous,
        );
    }

    public function isInvalidRootKey(): bool
    {
        return $this->isInvalidRootKey;
    }
}
