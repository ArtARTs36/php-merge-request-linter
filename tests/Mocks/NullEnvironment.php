<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Environment\AbstractEnvironment;

final class NullEnvironment extends AbstractEnvironment
{
    protected function get(string $key): mixed
    {
        return null;
    }
}
