<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

use Throwable;

class EnvironmentDataKeyNotFound extends MergeRequestLinterException
{
    public function __construct(protected string $dataKey, int $code = 0, Throwable $previous = null)
    {
        $message = "Var '$dataKey' in Environment not found";

        parent::__construct($message, $code, $previous);
    }
}
