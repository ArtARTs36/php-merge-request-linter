<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments;

final class NullEnvironment extends AbstractEnvironment
{
    protected function get(string $key): mixed
    {
        return false;
    }
}
