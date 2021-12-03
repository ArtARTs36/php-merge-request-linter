<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'install';

    protected static $defaultDescription = 'Install this tool';

    public function __construct(protected ConfigLoader $configLoader, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = getcwd();

        copy(__DIR__ . '/../../stubs/.mr-linter.php', $pathTo = $dir . '/.mr-linter.php');

        $style = new SymfonyStyle($input, $output);

        $style->info('Was copied configuration file to: '. $pathTo);

        return self::SUCCESS;
    }
}
