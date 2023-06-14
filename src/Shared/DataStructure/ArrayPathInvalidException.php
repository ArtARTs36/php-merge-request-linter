<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

final class ArrayPathInvalidException extends MergeRequestLinterException
{
    public function __construct(
        string $message,
        private readonly string $requiredArrayPath,
        private readonly string $stopArrayPath,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getRequiredArrayPath(): string
    {
        return $this->requiredArrayPath;
    }

    public function getStopArrayPath(): string
    {
        return $this->stopArrayPath;
    }
}
