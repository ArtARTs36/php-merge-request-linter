<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;

class VarNotFoundException extends MergeRequestLinterException implements EnvironmentVariableNotFoundException
{
    public function __construct(
        string $message,
        private readonly string $varName,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function make(string $var): self
    {
        return new self(
            sprintf('Environment variable with name \'%s\' not found', $var),
            $var,
        );
    }

    public function getVarName(): string
    {
        return $this->varName;
    }
}
