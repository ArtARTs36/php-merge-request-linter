<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class ConfigInvalidException extends ConfigException
{
    public static function fromKey(string $key): self
    {
        return new self("Config[$key] invalid!");
    }
}
