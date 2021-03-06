<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Console\DumpCommand;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigLoader;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Facade\Str;
use Symfony\Component\Console\Tester\CommandTester;

final class DumpCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Console\DumpCommand::execute
     */
    public function testExecute(): void
    {
        $configLoader = new MockConfigLoader(Config::fromArray([
            'rules' => [
                new SuccessRule(),
            ],
            'credentials' => [],
            'http_client' => fn () => null,
        ]));

        $tester = new CommandTester(new DumpCommand($configLoader));

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        self::assertStringContainsString(
            '1 Success rule ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule',
            Str::deleteUnnecessarySpaces($tester->getDisplay())
        );
    }
}
