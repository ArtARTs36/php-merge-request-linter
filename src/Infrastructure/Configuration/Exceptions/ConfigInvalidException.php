<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions;

class ConfigInvalidException extends ConfigException
{
    public static function fromKey(string $key): self
    {
        return new self("Config[$key] invalid!");
    }

    public static function keyNotSet(string $key): self
    {
        return new self("Config[$key] must be provided");
    }

    public static function keyEmpty(string $key): self
    {
        return new self("Config[$key] must be filled");
    }

    public static function invalidType(string $key, string $expected, string $actual): self
    {
        return new self(sprintf(
            'Config[%s] has invalid type. Expected type: %s, actual: %s',
            $key,
            $expected,
            $actual,
        ));
    }
}
