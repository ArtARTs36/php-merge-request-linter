<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class ConfigNotFound extends ConfigException
{
    public static function fromPath(string $path): self
    {
        return new self(sprintf('Config with path %s not found', $path));
    }

    public static function fromDirectory(string $directory): self
    {
        return new self(sprintf('Config in directory %s not found', $directory));
    }
}
