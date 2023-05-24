<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Presentation\Console\Output;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsoleLoggerTest extends TestCase
{
    public function providerForTestLog(): array
    {
        return [
            [
                'messages' => [
                    [LogLevel::INFO, 'test-message', []],
                ],
                'expected-log' => "[info] test-message {}\n",
            ],
            [
                'messages' => [
                    [LogLevel::INFO, 'test-message', ['k' => 'v']],
                ],
                'expected-log' => "[info] test-message {\"k\":\"v\"}\n",
            ],
            [
                'messages' => [
                    [LogLevel::INFO, 'test-message-1', []],
                    [LogLevel::INFO, 'test-message-2', ['k' => 'v']],
                ],
                'expected-log' => "[info] test-message-1 {}\n\n[info] test-message-2 {\"k\":\"v\"}\n",
            ],
            [
                'messages' => [],
                'expected-log' => '',
            ],
            'ignore-non-string-level' => [
                'messages' => [[
                    1, 'test-message', [],
                ]],
                'expected-log' => '',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger::log
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger::__construct
     * @dataProvider providerForTestLog
     */
    public function testLog(array $messages, string $expectedLog): void
    {
        $output = new BufferedOutput(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $logger = new ConsoleLogger($output, LocalClock::utc());

        foreach ($messages as [$level, $message, $context]) {
            $logger->log($level, $message, $context);
        }

        self::assertEquals($expectedLog, $output->fetch());
    }
}
