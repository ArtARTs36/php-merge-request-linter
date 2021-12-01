<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

use Throwable;

class EnvironmentDataKeyNotFound extends \RuntimeException
{
    public function __construct(protected string $dataKey, $code = 0, Throwable $previous = null)
    {
        $message = "'$dataKey' of Environment not found";

        parent::__construct($message, $code, $previous);
    }
}
