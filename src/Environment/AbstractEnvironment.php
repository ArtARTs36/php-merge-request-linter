<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;

abstract class AbstractEnvironment implements Environment
{
    abstract protected function get(string $key): mixed;

    public function getInt(string $key): int
    {
        return (int) $this->doGet($key);
    }

    public function getString(string $key): string
    {
        return (string) $this->doGet($key);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== false;
    }

    protected function doGet(string $key): mixed
    {
        $value = $this->get($key);

        if ($value === false) {
            throw EnvironmentVariableNotFound::make($key);
        }

        return $value;
    }
}
