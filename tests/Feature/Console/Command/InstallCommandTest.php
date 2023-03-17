<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\Cwd;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

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
        self::assertStringContainsString('Was copied configuration file to:', $tester->getDisplay());

        @unlink($expectedFilename);

        $cwd->revert();
    }
}
