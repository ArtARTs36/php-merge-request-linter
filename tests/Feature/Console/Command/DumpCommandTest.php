<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Feature\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Application\Rule\TaskHandlers\DumpTaskHandler;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Facade\Str;
use Symfony\Component\Console\Tester\CommandTester;

final class DumpCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand::execute
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand::configure
     */
    public function testExecute(): void
    {
        $tester = new CommandTester(
            new DumpCommand(
                new DumpTaskHandler(new MockConfigResolver(
                    $this->makeConfig([
                        new SuccessRule(),
                    ]),
                ), new RuleDumper()),
            ),
        );

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        self::assertStringContainsString(
            'success_rule Success rule true',
            Str::deleteUnnecessarySpaces($tester->getDisplay())
        );
    }
}
