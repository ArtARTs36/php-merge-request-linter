<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class EnvironmentVariableNotFound extends MergeRequestLinterException
{
    public static function make(string $var): self
    {
        return new self(
            sprintf('Environment variable with name \'%s\' not found', $var),
        );
    }
}
