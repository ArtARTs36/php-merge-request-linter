<?php

namespace ArtARTs36\MergeRequestLinter\Environment;

class LocalEnvironment extends AbstractEnvironment
{
    protected function get(string $key): mixed
    {
        return getenv($key);
    }
}
