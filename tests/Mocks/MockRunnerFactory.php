<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\NullRegistry;

final class MockRunnerFactory implements LinterRunnerFactory
{
    public function __construct(private CiSystemFactory $ciSystemFactory)
    {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(new CiRequestFetcher($this->ciSystemFactory, new NullRegistry()));
    }
}
