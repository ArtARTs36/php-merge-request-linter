<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;

interface ConfigResolver
{
    public function resolve(string $directory, ?string $userFormat = null): ResolvedConfig;
}
