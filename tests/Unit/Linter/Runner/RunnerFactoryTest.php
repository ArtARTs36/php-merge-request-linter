<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory::__construct
     */
    public function testCreate(): void
    {
        self::assertInstanceOf(Runner::class, (new RunnerFactory(new NullEnvironment()))->create(
            Config::fromArray([
                'rules' => [],
                'credentials' => [],
                'http_client' => new NullClient(),
            ]),
        ));
    }
}
