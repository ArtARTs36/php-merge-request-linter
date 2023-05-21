<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;

final class ChainEnvironment implements Environment
{
    /**
     * @param iterable<Environment> $environments
     */
    public function __construct(
        private readonly iterable $environments,
    ) {
        //
    }

    public function has(string $key): bool
    {
        foreach ($this->environments as $environment) {
            if ($environment->has($key)) {
                return true;
            }
        }

        return false;
    }

    public function getString(string $key): string
    {
        foreach ($this->environments as $environment) {
            if ($environment->has($key)) {
                return $environment->getString($key);
            }
        }

        throw VarNotFoundException::make($key);
    }

    public function getInt(string $key): int
    {
        foreach ($this->environments as $environment) {
            if ($environment->has($key)) {
                return $environment->getInt($key);
            }
        }

        throw VarNotFoundException::make($key);
    }
}
