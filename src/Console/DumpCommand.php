<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ConfigResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpCommand extends Command
{
    use HasConfigFileOption;

    protected static $defaultName = 'dump';

    protected static $defaultDescription = 'Print current rules';

    public function __construct(protected ConfigResolver $config, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addConfigFileOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->config->resolve(getcwd(), $input->getOption('config'));

        $style = new SymfonyStyle($input, $output);

        $style->info('Config path: '. $config->path);

        $rows = [];
        $i = 0;

        foreach ($config->config->getRules() as $rule) {
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
