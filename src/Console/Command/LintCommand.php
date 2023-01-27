<?php

namespace ArtARTs36\MergeRequestLinter\Console\Command;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Console\Interaction\LintSubscriber;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\IO\Console\ConsolePrinter;
use ArtARTs36\MergeRequestLinter\IO\Console\SymfonyProgressBar;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use ArtARTs36\MergeRequestLinter\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Support\Bytes;
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
        protected MetricManager $metrics,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addConfigFileOption();

        $this->addOption('debug');
        $this->addOption('metrics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isDebug = $input->getOption('debug');

        if ($isDebug) {
            $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
        }

        $style = new SymfonyStyle($input, $output);

        // Resolve and print config

        $config = $this->resolveConfig($input);

        $this->printInfoMessage($output, sprintf('Config path: %s', $config->path));

        if ($isDebug) {
            $style->newLine(2);

            $this->printInfoMessage($output, sprintf(
                'Used rules: %s',
                $config->config->getRules()->implodeNames(', '),
            ));

            $style->newLine(2);
        }

        $progressBar = new ProgressBar($output, $config->config->getRules()->count());

        $linter = new Linter(
            $config->config->getRules(),
            new LintSubscriber(
                new SymfonyProgressBar($progressBar),
                new ConsolePrinter($style),
                $input->getOption('debug'),
            ),
        );

        $result = $this->runnerFactory->create($config->config)->run($linter);

        $style->newLine(2);

        $this->printNotes($style, $result->notes);

        $this->printMetrics($style, $config->config, $result, $input->getOption('metrics'));

        if ($result->isFail()) {
            $style->error(sprintf('Found %d notes', $result->notes->count()));

            return self::FAILURE;
        }

        $style->success('No notes');

        return self::SUCCESS;
    }

    private function printMetrics(StyleInterface $style, Config $config, LintResult $result, bool $fullMetrics): void
    {
        $metrics = [
            ['[Linter] Rules', $config->getRules()->count()],
            ['[Linter] Notes', $result->notes->count()],
            ['[Linter] Duration', $result->duration],
            ['[Memory] Memory peak usage', Bytes::toString(memory_get_peak_usage(true))],
        ];

        if ($fullMetrics) {
            foreach ($this->metrics->describe() as $record) {
                $metrics[] = [$record->subject->name, $record->getValue()];
            }
        }

        $style->table(['Metric', 'Value'], $metrics);
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

    private function printInfoMessage(OutputInterface $output, string $message): void
    {
        $output->write(sprintf('<info> [INFO] %s</info>', $message));
    }
}
