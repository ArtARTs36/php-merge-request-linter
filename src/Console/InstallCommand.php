<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected static $defaultName = 'install';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = getcwd();

        copy(__DIR__ . '/../../.mr-linter.php', $dir . '/mr-linter.php');

        return self::SUCCESS;
    }
}
