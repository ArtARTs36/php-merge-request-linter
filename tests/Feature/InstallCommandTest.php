<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature;

use ArtARTs36\MergeRequestLinter\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\Cwd;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class InstallCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Console\Command\InstallCommand::execute
     */
    public function testExecute(): void
    {
        $cwd = new Cwd();

        $cwd->set(__DIR__);

        $command = new InstallCommand();
        $tester = new CommandTester($command);

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
        self::assertFileExists('.mr-linter.php');
        self::assertStringContainsString('Was copied configuration file to:', $tester->getDisplay());

        @unlink('.mr-linter.php');

        $cwd->revert();
    }
}
