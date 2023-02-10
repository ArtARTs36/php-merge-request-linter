<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Support\File\Directory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\Cwd;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class InstallCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::execute
     */
    public function testExecute(): void
    {
        $cwd = new Cwd();

        $cwd->set(__DIR__);

        $command = new InstallCommand(new Copier(new Directory(__DIR__ . '/../../stubs/')));
        $tester = new CommandTester($command);

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
        self::assertFileExists('.mr-linter.php');
        self::assertStringContainsString('Was copied configuration file to:', $tester->getDisplay());

        @unlink('.mr-linter.php');

        $cwd->revert();
    }
}
