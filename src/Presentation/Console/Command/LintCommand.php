<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Linter\TaskHandlers\LintTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Linter\Tasks\LintTask;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsolePrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\SymfonyProgressBar;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\SymfonyTablePrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\Metric;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\MetricPrinter;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\NotePrinter;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\File\Bytes;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;
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
        protected MetricManager $metrics,
        protected EventManager $events,
        private readonly LintTaskHandler $handler,
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
        $isDebug = $this->getBoolFromOption($input, 'debug');

        if ($isDebug) {
            $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
        }

        $style = new SymfonyStyle($input, $output);

        $this->events->subscribe(new LintEventsSubscriber(
            new SymfonyProgressBar(new ProgressBar($output)),
            new ConsolePrinter($style),
            $isDebug,
        ));

        $result = $this->handler->handle(new LintTask(
            $this->getWorkDir($input),
            $this->getStringOptionFromInput($input, 'config'),
        ));

        $style->newLine(2);

        if (! $result->notes->isEmpty()) {
            $this->notePrinter->print(new SymfonyTablePrinter($style), $result->notes);
        }

        $this->printMetrics($style, $result, $this->getBoolFromOption($input, 'metrics'));

        if ($result->isFail()) {
            $style->error(sprintf('Found %d notes', $result->notes->count()));

            return self::FAILURE;
        }

        $style->success('No notes');

        return self::SUCCESS;
    }

    private function printMetrics(StyleInterface $style, LintResult $result, bool $fullMetrics): void
    {
        $metrics = new Arrayee([
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
}
