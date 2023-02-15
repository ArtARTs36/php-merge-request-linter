<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Output;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Symfony\Component\Console\Logger\ConsoleLogger as SymfonyConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

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
        if (is_string($level) && $this->willBeLogged($level)) {
            $this->output->write("\n");
            $this->logger->log($level, $message, $context);
        }
    }

    private function willBeLogged(string $level): bool
    {
        /** @var array<string, int> $verbosityLevelMap */
        $verbosityLevelMap = (function () {
            return $this->verbosityLevelMap ?? [];
        })->call($this->logger);

        return isset($verbosityLevelMap[$level]) && $this->output->getVerbosity() >= $verbosityLevelMap[$level];
    }
}
