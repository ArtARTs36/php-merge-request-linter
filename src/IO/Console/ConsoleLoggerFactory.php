<?php

namespace ArtARTs36\MergeRequestLinter\IO\Console;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger as SymfonyConsoleLogger;

class ConsoleLoggerFactory
{
    public function create(OutputInterface $output): LoggerInterface
    {
        return new ConsoleLogger(
            new SymfonyConsoleLogger($output),
            $output,
        );
    }
}
