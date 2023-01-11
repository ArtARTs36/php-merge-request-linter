<?php

namespace ArtARTs36\MergeRequestLinter\IO\Console;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger as SymfonyConsoleLogger;

class ConsoleLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        private SymfonyConsoleLogger $logger,
        private OutputInterface      $output,
    ) {
        //
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->output->write("\n");
        $this->logger->log($level, $message, $context);
    }
}
