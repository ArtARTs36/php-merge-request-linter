<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter\TaskHandlers;

use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\TaskHandlers\LintTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Linter\Tasks\LintTask;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockRunnerFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class LintTaskHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $configResolver = $this->createMock(ConfigResolver::class);
        $configResolver
            ->expects(new InvokedCount(1))
            ->method('resolve')
            ->willReturn($config = new ResolvedConfig(
                new Config(
                    new Rules([]),
                    new ArrayMap([]),
                    new HttpClientConfig('', []),
                    new NotificationsConfig(new ArrayMap([]), new ArrayMap([])),
                    new LinterConfig(new LinterOptions()),
                    new CommentsConfig(CommentsPostStrategy::New, []),
                ),
                '',
            ));

        $eventDispatcher = new MockEventDispatcher();

        $linter = $this->createMock(\ArtARTs36\MergeRequestLinter\Domain\Linter\Linter::class);

        $linterFactory = $this->createMock(LinterFactory::class);
        $linterFactory
            ->expects(new InvokedCount(1))
            ->method('create')
            ->willReturn($linter);

        $handler = new LintTaskHandler(
            $configResolver,
            $eventDispatcher,
            $linterFactory,
            new MockRunnerFactory(new MockCiSystemFactory(new MockCi())),
        );

        $lintResult = $handler->handle(new LintTask('', ''));

        self::assertEquals(LintState::Success, $lintResult->state);
        $eventDispatcher->assertDispatchedObject(new ConfigResolvedEvent($config));
    }
}
