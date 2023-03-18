<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Output;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleLoggerFactory
{
    public function create(OutputInterface $output): LoggerInterface
    {
        return new ConsoleLogger(
            $output,
        );
    }
}
