<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LintCommand extends Command
{
    use HasConfigFileOption;

    protected static $defaultName = 'lint';

    protected static $defaultDescription = 'Run lint to current merge request';

    public function __construct(
        protected ConfigResolver $config,
        protected LinterRunnerFactory $runnerFactory,
        string                    $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addConfigFileOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        // Resolve and print config

        $config = $this->resolveConfig($input);

        $style->info('Config path: '. $config->path);

        //

        $progressBar = new ProgressBar($output, $config->config->getRules()->count());

        $linter = new Linter($config->config->getRules(), new ProgressBarLintSubscriber($progressBar));

        $result = $this->runnerFactory->create($config->config)->run($linter);

        $notes = [];

        /** @var Note $note */
        foreach ($result->notes as $i => $note) {
            $notes[] = [++$i, $note->getDescription()];
        }

        $style->newLine(2);

        if (count($notes) > 0) {
            $style->table(['#', 'Note'], $notes);
        }

        $style->table(['Metric', 'Value'], [
            ['Rules', $config->config->getRules()->count()],
            ['Notes', count($notes)],
            ['Duration', $result->duration . 'ms'],
        ]);

        if ($result->isFail()) {
            $style->error(sprintf('Found %d notes', count($notes)));
        } else {
            $style->success('No notes');
        }

        return $result->isFail() ? self::FAILURE : self::SUCCESS;
    }
}
