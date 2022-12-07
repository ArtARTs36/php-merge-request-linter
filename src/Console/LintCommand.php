<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Contracts\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use Symfony\Component\Console\Command\Command;
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

    protected function configure()
    {
        $this->addConfigFileOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->config->resolve(getcwd(), $input->getOption('config'));
        $linter = new Linter($config->config->getRules());

        $result = $this->runnerFactory->create($config->config)->run($linter);

        $style = new SymfonyStyle($input, $output);

        $style->info('Config path: '. $config->path);

        if ($result->isFail()) {
            $style->error('Detected notes');
        } else {
            $style->info('All good!');
        }

        $notes = [];

        /** @var Note $note */
        foreach ($result->notes as $note) {
            $notes[] = [$note->getDescription()];
        }

        if (count($notes) > 0) {
            $style->table(['Note'], $notes);
        }

        $style->table(['Metric', 'Value'], [
            ['Notes', count($notes)],
            ['Duration', $result->duration . 'ms'],
        ]);

        return $result->isFail() ? self::FAILURE : self::SUCCESS;
    }
}
