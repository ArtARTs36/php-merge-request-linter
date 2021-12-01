<?php

namespace ArtARTs36\MergeRequestLinter\Ci;

abstract class AbstractIntegration implements CiSystem
{
    protected function env(string $key): string
    {
        return getenv($key);
    }
}
