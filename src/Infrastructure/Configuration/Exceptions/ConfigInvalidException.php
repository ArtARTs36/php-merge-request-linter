<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions;

class ConfigInvalidException extends ConfigException
{
    public static function fromKey(string $key): self
    {
        return new self("Config[$key] invalid!");
    }
}
