<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;

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
