<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Linter;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;

/**
 * Factory for LinterRunner
 */
interface LinterRunnerFactory
{
    /**
     * Create LinterRunner instance
     */
    public function create(Config $config): LinterRunner;
}
