<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Request\RequestFetcher;
use OndraM\CiDetector\CiDetector;

class RunnerFactory implements LinterRunnerFactory
{
    public function create(Config $config): LinterRunner
    {
        return new LinterRunner(
            new CiDetector(),
            new RequestFetcher(
                new SystemFactory($config->getCredentials()),
            ),
        );
    }
}
