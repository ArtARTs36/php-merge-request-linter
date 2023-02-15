<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions;

class ConfigNotFound extends ConfigException
{
    public static function fromPath(string $path, ?\Throwable $prev = null): self
    {
        return new self(sprintf('Config with path %s not found', $path), previous: $prev);
    }

    public static function fromDirectory(string $directory): self
    {
        return new self(sprintf('Config in directory %s not found', $directory));
    }
}
