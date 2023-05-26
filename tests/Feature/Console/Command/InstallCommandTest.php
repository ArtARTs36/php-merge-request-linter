<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\CommandTester;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\Cwd;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class InstallCommandTest extends TestCase
{
    public function providerForTestExecute(): array
    {
        return [
            [
                [],
                '.mr-linter.yaml',
            ],
            [
                ['--format' => ConfigFormat::JSON->value],
                '.mr-linter.json',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::execute
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::resolveConfigFormat
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::configure
     * @dataProvider providerForTestExecute
     */
    public function testExecute(array $options, string $expectedFilename): void
    {
        $cwd = new Cwd();

        $cwd->set(__DIR__);

        $command = new InstallCommand(new CreateConfigTaskHandler(new Copier(new Directory(__DIR__ . '/../../../../stubs/'))));
        $tester = new CommandTester($command);

        $tester->execute($options);

        $tester->assertCommandIsSuccessful();
        self::assertFileExists($expectedFilename);

        $tester->assertDisplayContainsString('Was copied configuration file to:');

        @unlink($expectedFilename);

        $cwd->revert();
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::execute
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand::resolveConfigFormat
     */
    public function testExecuteOnConfigFormatNotSupported(): void
    {
        $command = new InstallCommand(new CreateConfigTaskHandler(new Copier(new Directory(__DIR__ . '/../../../../stubs/'))));
        $tester = new CommandTester($command);

        self::expectExceptionMessage('Format "ee" not supported');

        $tester->execute(['--format' => 'ee']);
    }
}
