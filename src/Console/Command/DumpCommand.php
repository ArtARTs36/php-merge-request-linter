<?php

namespace ArtARTs36\MergeRequestLinter\Console\Command;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Rule\Dumper\RuleDumper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpCommand extends Command
{
    use HasConfigFileOption;

    protected static $defaultName = 'dump';

    protected static $defaultDescription = 'Print current rules';

    public function __construct(
        protected ConfigResolver $config,
        private readonly RuleDumper $dumper,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addConfigFileOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->resolveConfig($input);

        $style = new SymfonyStyle($input, $output);

        $style->info('Config path: '. $config->path);

        $rows = [];
        $i = 0;

        foreach ($this->dumper->dump($config->config->getRules()) as $rule) {
            $rows[] = [
                ++$i,
                $rule->definition,
                $rule->class,
            ];
        }

        $style->table(['#', 'Definition', 'Class'], $rows);

        return self::SUCCESS;
    }
}
