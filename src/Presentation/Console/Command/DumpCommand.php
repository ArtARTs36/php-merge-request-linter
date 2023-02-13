<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Rule\TaskHandlers\DumpTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Rule\Tasks\DumpTask;
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
        private readonly DumpTaskHandler  $handler,
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
        $style = new SymfonyStyle($input, $output);

        $info = $this->handler->handle(
            new DumpTask(
                $this->getWorkDir($input),
                $input->getOption('config'),
            ),
        );

        $style->info('Config path: '. $info->configPath);

        $this->printer->print(new SymfonyTablePrinter($style), $info->infos);

        return self::SUCCESS;
    }
}
