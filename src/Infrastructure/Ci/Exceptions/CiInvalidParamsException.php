<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class CiInvalidParamsException extends MergeRequestLinterException
{
    public function __construct(
        public readonly string $key,
        string $message,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
