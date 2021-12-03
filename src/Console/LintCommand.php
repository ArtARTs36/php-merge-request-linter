<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LintCommand extends Command
{
    protected static $defaultName = 'lint';

    protected static $defaultDescription = 'Run lint to current merge request';

    protected LinterRunnerFactory $runnerFactory;

    public function __construct(
        protected ConfigLoader $configLoader,
        ?LinterRunnerFactory      $runnerFactory = null,
        string                    $name = null
    ) {
        $this->runnerFactory = $runnerFactory ?? new RunnerFactory(new LocalEnvironment());

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->configLoader->load($path = getcwd() . DIRECTORY_SEPARATOR . '.mr-linter.php');
        $linter = new Linter($config->getRules());

        $result = $this->runnerFactory->create($config)->run($linter);

        $style = new SymfonyStyle($input, $output);

        $style->info('Config path: '. $path);

        if ($result->isFail()) {
            $style->error('Detected notes');
        } else {
            $style->info('All good!');
        }

        /** @var Note $note */
        foreach ($result->notes as $note) {
            $style->error($note->getDescription());
        }

        $style->info('Duration: '. $result->duration);

        return $result->isFail() ? self::FAILURE : self::SUCCESS;
    }
}
