<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory;
use ArtARTs36\MergeRequestLinter\Report\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class RunnerFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new RunnerFactory(new NullEnvironment(), new ArrayMap([]), new NullLogger(), new NullMetricManager());

        self::assertInstanceOf(Runner::class, $factory->create(
            $this->makeConfig([]),
        ));
    }
}
