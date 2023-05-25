<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Presentation\Console\Output;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClock;
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
                'current-time' => '2020-02-02 14:32:01',
                'expected-log' => "[2020-02-02 14:32:01] [info] test-message {}\n",
            ],
            [
                'messages' => [
                    [LogLevel::INFO, 'test-message', ['k' => 'v']],
                ],
                'current-time' => '2020-02-02 14:32:01',
                'expected-log' => "[2020-02-02 14:32:01] [info] test-message {\"k\":\"v\"}\n",
            ],
            [
                'messages' => [
                    [LogLevel::INFO, 'test-message-1', []],
                    [LogLevel::INFO, 'test-message-2', ['k' => 'v']],
                ],
                'current-time' => '2020-02-02 14:32:01',
                'expected-log' => "[2020-02-02 14:32:01] [info] test-message-1 {}\n\n[2020-02-02 14:32:01] [info] test-message-2 {\"k\":\"v\"}\n",
            ],
            [
                'messages' => [],
                'current-time' => '2020-02-02 14:32:01',
                'expected-log' => '',
            ],
            'ignore-non-string-level' => [
                'messages' => [[
                    1, 'test-message', [],
                ]],
                'current-time' => '2020-02-02 14:32:01',
                'expected-log' => '',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger::log
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger::__construct
     * @dataProvider providerForTestLog
     */
    public function testLog(array $messages, string $currentTime, string $expectedLog): void
    {
        $output = new BufferedOutput(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $logger = new ConsoleLogger($output, new MockClock($currentTime));

        foreach ($messages as [$level, $message, $context]) {
            $logger->log($level, $message, $context);
        }

        self::assertEquals($expectedLog, $output->fetch());
    }
}
