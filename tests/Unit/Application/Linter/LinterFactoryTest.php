<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinterFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new LinterFactory(
            new NullEventDispatcher(),
            new NullMetricManager(),
        );

        $gotLinter = $factory->create(new Config(
            new Rules([]),
            new ArrayMap([]),
            new HttpClientConfig(HttpClientConfig::TYPE_NULL, []),
            new NotificationsConfig(new ArrayMap([]), new ArrayMap([])),
            new LinterConfig(new LinterOptions()),
            new CommentsConfig(CommentsPostStrategy::New, []),
        ));

        self::assertInstanceOf(Linter::class, $gotLinter);
    }
}
