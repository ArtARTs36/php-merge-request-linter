<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Linter\RunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class RunnerFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Linter\RunnerFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Linter\RunnerFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new RunnerFactory(new NullEnvironment(), new ArrayMap([]), new NullLogger(), new NullMetricManager(), new ClientFactory(new NullMetricManager()));

        self::assertInstanceOf(Runner::class, $factory->create(
            $this->makeConfig([]),
        ));
    }
}
