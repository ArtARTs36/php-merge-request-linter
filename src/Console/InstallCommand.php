<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'install';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = getcwd();

        copy(__DIR__ . '/../../stubs/.mr-linter.php', $pathTo = $dir . '/.mr-linter.php');

        $style = new SymfonyStyle($input, $output);

        $style->info('Was copied configuration file to: '. $pathTo);

        return self::SUCCESS;
    }
}
