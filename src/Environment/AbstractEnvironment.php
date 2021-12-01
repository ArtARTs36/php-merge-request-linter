<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;

abstract class AbstractEnvironment implements Environment
{
    abstract protected function get(string $key): mixed;

    public function getInt(string $key): ?int
    {
        return ($value = $this->get($key)) === null ? null : (int) $value;
    }

    public function getString(string $key): ?string
    {
        return ($value = $this->get($key)) === null ? null : (string) $value;
    }
}
