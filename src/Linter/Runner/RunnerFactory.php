<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Request\Fetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\Http\ClientFactory;

class RunnerFactory implements LinterRunnerFactory
{
    /**
     * @param Map<string, class-string<CiSystem>> $ciSystems
     */
    public function __construct(protected Environment $environment, protected Map $ciSystems)
    {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(
            new CiRequestFetcher(
                new SystemFactory($config, $this->environment, new ClientFactory(), $this->ciSystems),
            ),
        );
    }
}
