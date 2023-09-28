<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\TaskHandlers\LintTaskHandler;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\NullRegistry;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockRunnerFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\CommandTester;

final class LintCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand::execute
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand::configure
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand::printMetrics
     */
    public function testExecuteAllGood(): void
    {
        $tester = new CommandTester(
            new LintCommand(
                $metrics = new NullRegistry(),
                $events = new NullEventDispatcher(),
                new LintTaskHandler(
                    new MockConfigResolver($this->makeConfig([new SuccessRule()])),
                    $events,
                    new LinterFactory($events, $metrics),
                    new MockRunnerFactory(new MockCiSystemFactory(new MockCi(request: $this->makeMergeRequest()))),
                ),
            )
        );

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        $tester->assertDisplayContainsString('No notes');
    }
}
