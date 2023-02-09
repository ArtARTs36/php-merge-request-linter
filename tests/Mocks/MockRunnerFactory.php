<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Manager\NullMetricManager;

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
