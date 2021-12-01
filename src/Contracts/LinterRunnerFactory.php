<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Linter\LinterRunner;

interface LinterRunnerFactory
{
    public function create(Config $config): LinterRunner;
}
