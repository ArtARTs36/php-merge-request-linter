<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Linter\LinterRunner;

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
