<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Request\CiMergeRequestFetcher;

final class MockRunnerFactory implements LinterRunnerFactory
{
    public function __construct(private CiSystemFactory $ciSystemFactory)
    {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(new CiMergeRequestFetcher($this->ciSystemFactory));
    }
}
