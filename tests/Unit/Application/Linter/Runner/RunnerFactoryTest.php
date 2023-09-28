<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter\Runner;

use ArtARTs36\ContextLogger\LoggerFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Application\Linter\RunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\NullRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\RunnerFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\RunnerFactory::createSystemFactory
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\RunnerFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new RunnerFactory(
            new NullEnvironment(),
            new ArrayMap([]),
            LoggerFactory::null(),
            new NullRegistry(),
            new ClientFactory(new NullRegistry(), LoggerFactory::null()),
            LocalClock::utc(),
        );

        self::assertInstanceOf(Runner::class, $factory->create(
            $this->makeConfig([]),
        ));
    }
}
