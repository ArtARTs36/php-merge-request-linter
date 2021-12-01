<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentDataKeyNotFound;

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

    protected function doGet(string $key): mixed
    {
        $value = $this->get($key);

        if ($value === null) {
            throw new EnvironmentDataKeyNotFound($key);
        }

        return $value;
    }
}
