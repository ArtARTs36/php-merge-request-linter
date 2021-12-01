<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;

abstract class AbstractCiSystem implements CiSystem
{
    protected function env(string $key): string
    {
        return getenv($key);
    }
}
