<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\SymfonyTablePrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\RuleInfoPrinter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpCommand extends Command
{
    use HasConfigFileOption;

    protected static $defaultName = 'dump';

    protected static $defaultDescription = 'Print current rules';

    public function __construct(
        protected readonly ConfigResolver $config,
        private readonly RuleDumper       $dumper,
        private readonly RuleInfoPrinter  $printer = new RuleInfoPrinter(),
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

        $this->printer->print(new SymfonyTablePrinter($style), $this->dumper->dump($config->config->getRules()));

        return self::SUCCESS;
    }
}
