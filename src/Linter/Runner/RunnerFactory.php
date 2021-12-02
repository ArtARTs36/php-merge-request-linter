<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use Psr\Http\Client\ClientInterface;

class RunnerFactory implements LinterRunnerFactory
{
    public function __construct(protected Environment $environment, protected ClientInterface $client)
    {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(
            new SystemFactory($config->getCredentials(), $this->environment, $this->client),
        );
    }
}
