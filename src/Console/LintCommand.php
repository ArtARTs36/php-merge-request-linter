<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LintCommand extends Command
{
    protected static $defaultName = 'lint';

    protected LinterRunnerFactory $runnerFactory;

    public function __construct(?LinterRunnerFactory $runnerFactory = null, string $name = null)
    {
        $this->runnerFactory = $runnerFactory ?? new RunnerFactory();

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = (new ConfigLoader())->load(getcwd() . DIRECTORY_SEPARATOR . '.mr-linter.php');
        $linter = new Linter($config->getRules());

        $result = $this->runnerFactory->create($config)->run($linter);

        $style = new SymfonyStyle($input, $output);

        $style->comment($result->getState());

        /** @var LintError $error */
        foreach ($result->errors as $error) {
            $style->error($error->description);
        }

        $style->info('Duration: '. $result->duration);

        return $result->isFail() ? 1 : 0;
    }
}
