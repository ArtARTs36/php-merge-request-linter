<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments;

class LocalEnvironment extends AbstractEnvironment
{
    protected function get(string $key): mixed
    {
        return getenv($key);
    }
}
