<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Console\Interaction\ConsolePrinter;
use ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber;
use ArtARTs36\MergeRequestLinter\Console\Interaction\SymfonyProgressBar;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
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

        $this->addOption('debug');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        // Resolve and print config

        $config = $this->resolveConfig($input);

        $style->info('Config path: '. $config->path);

        //

        $progressBar = new ProgressBar($output, $config->config->getRules()->count());

        $linter = new Linter(
            $config->config->getRules(),
            new ProgressBarLintSubscriber(
                new SymfonyProgressBar($progressBar),
                new ConsolePrinter($style),
                $input->getOption('debug'),
            ),
        );

        $result = $this->runnerFactory->create($config->config)->run($linter);

        $style->newLine(2);

        $this->printNotes($style, $result->notes);

        $style->table(['Metric', 'Value'], [
            ['Rules', $config->config->getRules()->count()],
            ['Notes', $result->notes->count()],
            ['Duration', $result->duration],
        ]);

        if ($result->isFail()) {
            $style->error(sprintf('Found %d notes', $result->notes->count()));
        } else {
            $style->success('No notes');
        }

        return $result->isFail() ? self::FAILURE : self::SUCCESS;
    }

    private function printNotes(StyleInterface $style, Notes $notes): void
    {
        if ($notes->isEmpty()) {
            return;
        }

        $table = [];

        $tableCellOptions = [
            NoteSeverity::Fatal->value => [
                'style' => new TableCellStyle([
                    'fg' => 'red',
                ]),
            ],
            NoteSeverity::Normal->value => [],
        ];

        $counter = 0;

        /** @var Note $note */
        foreach ($notes as $note) {
            ++$counter;

            $table[] = [
                new TableCell("$counter", $tableCellOptions[$note->getSeverity()->value]),
                new TableCell($note->getDescription(), $tableCellOptions[$note->getSeverity()->value]),
            ];
        }

        $style->table(['#', 'Note'], $table);
    }
}
