<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;

final class MockRunnerFactory implements LinterRunnerFactory
{
    public function __construct(private CiSystemFactory $ciSystemFactory)
    {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(new CiRequestFetcher($this->ciSystemFactory, new NullMetricManager()));
    }
}
