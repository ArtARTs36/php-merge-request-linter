<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

use Throwable;

class StopLintException extends LintException
{
    public function __construct(string $message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
