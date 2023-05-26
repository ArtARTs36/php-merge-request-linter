<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Output;

use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleLogger implements LoggerInterface
{
    use LoggerTrait;

    /** @var array<string, string> */
    private array $formatLevelMap = [
        LogLevel::EMERGENCY => LogLevel::ERROR,
        LogLevel::ALERT => LogLevel::ERROR,
        LogLevel::CRITICAL => LogLevel::ERROR,
        LogLevel::ERROR => LogLevel::ERROR,
        LogLevel::WARNING => LogLevel::INFO,
        LogLevel::NOTICE => LogLevel::INFO,
        LogLevel::INFO => LogLevel::INFO,
        LogLevel::DEBUG => LogLevel::INFO,
    ];

    public function __construct(
        private readonly OutputInterface $output,
        private readonly ClockInterface $clock,
    ) {
        //
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        if (! is_string($level)) {
            return;
        }

        $output = $this->output;

        if (LogLevel::ERROR === $this->formatLevelMap[$level] && $output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        $output->writeln(
            sprintf(
                '<%1$s>[%2$s] [%3$s] %4$s %5$s</%1$s>',
                $this->formatLevelMap[$level],
                $this->clock->now()->format('Y-m-d H:i:s'),
                $level,
                $message,
                json_encode($context, JSON_FORCE_OBJECT),
            ),
            OutputInterface::VERBOSITY_VERY_VERBOSE,
        );
    }
}
