<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Console\LintCommand;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigLoader;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockRunnerFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class LintCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Console\LintCommand::execute
     */
    public function testExecuteAllGood(): void
    {
        $configLoader = new MockConfigLoader(Config::fromArray([
            'rules' => [
                new SuccessRule(),
            ],
            'credentials' => [],
            'http_client' => fn () => null,
        ]));

        $tester = new CommandTester(new LintCommand($configLoader, new MockRunnerFactory(
            new MockCiSystemFactory(MockCi::fromMergeRequest($this->makeMergeRequest()))
        )));

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        self::assertStringContainsString('All good!', $tester->getDisplay());
    }
}
