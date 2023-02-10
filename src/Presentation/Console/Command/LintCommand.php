<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintSubscriber;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsolePrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\SymfonyProgressBar;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\SymfonyTablePrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\Metric;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\MetricPrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\NotePrinter;
use ArtARTs36\MergeRequestLinter\Support\Bytes;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use Symfony\Component\Console\Helper\ProgressBar;
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
        protected readonly NotePrinter $notePrinter = new NotePrinter(),
        protected readonly MetricPrinter $metricPrinter = new MetricPrinter(),
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

        if (! $result->notes->isEmpty()) {
            $this->notePrinter->print(new SymfonyTablePrinter($style), $result->notes);
        }

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
        $metrics = new Arrayee([
            new Metric('[Linter] Rules', '' . $config->getRules()->count()),
            new Metric('[Linter] Notes', '' . $result->notes->count()),
            new Metric('[Linter] Duration', $result->duration),
            new Metric('[Memory] Memory peak usage', Bytes::toString(memory_get_peak_usage(true))),
        ]);

        if ($fullMetrics) {
            $metrics = $metrics->merge(
                $this->metrics->describe()->mapToArray(
                    static fn (Record $record) => new Metric($record->subject->name, $record->getValue()),
                )
            );
        }

        $this->metricPrinter->print(new SymfonyTablePrinter($style), $metrics);
    }

    private function printInfoMessage(OutputInterface $output, string $message): void
    {
        $output->write(sprintf('<info> [INFO] %s</info>', $message));
    }
}
