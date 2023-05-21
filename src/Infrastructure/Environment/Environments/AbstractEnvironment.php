<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;

abstract class AbstractEnvironment implements Environment
{
    abstract protected function get(string $key): mixed;

    public function getInt(string $key): int
    {
        $value = $this->doGet($key);

        if (! is_numeric($value)) {
            throw VarHasDifferentTypeException::make($key, 'int|float', gettype($value));
        }

        return (int) $value;
    }

    public function getString(string $key): string
    {
        $value = $this->doGet($key);

        if (! is_scalar($value)) {
            throw VarHasDifferentTypeException::make($key, 'string', gettype($value));
        }

        return (string) $value;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== false;
    }

    protected function doGet(string $key): mixed
    {
        $value = $this->get($key);

        if ($value === false) {
            throw VarNotFoundException::make($key);
        }

        return $value;
    }
}
