<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature;

use ArtARTs36\MergeRequestLinter\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockRunnerFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class LintCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Console\Command\LintCommand::execute
     */
    public function testExecuteAllGood(): void
    {
        $tester = new CommandTester(
            new LintCommand(
                new MockConfigResolver($this->makeConfig([new SuccessRule()])),
                new MockRunnerFactory(new MockCiSystemFactory(MockCi::fromMergeRequest($this->makeMergeRequest()))),
            )
        );

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        self::assertStringContainsString('No notes', $tester->getDisplay());
    }
}
