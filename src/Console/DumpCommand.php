<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Configuration\ConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpCommand extends Command
{
    protected static $defaultName = 'dump';

    protected static $defaultDescription = 'Print current rules';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = (new ConfigLoader())->load($path = getcwd() . DIRECTORY_SEPARATOR . '.mr-linter.php');

        $style = new SymfonyStyle($input, $output);

        $style->info('Config path: '. $path);

        $rows = [];
        $i = 0;

        foreach ($config->getRules() as $rule) {
            $rows[] = [
                ++$i,
                $rule->getDefinition(),
                $rule::class,
            ];
        }

        $style->table(['#', 'Definition', 'Class'], $rows);

        return self::SUCCESS;
    }
}
