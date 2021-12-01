<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Request\RequestFetcher;
use ArtARTs36\MergeRequestLinter\Support\Map;
use OndraM\CiDetector\CiDetector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LintCommand extends Command
{
    protected static $defaultName = 'lint';

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = (new ConfigLoader())->load(getcwd() . DIRECTORY_SEPARATOR . '.mr-linter.php');
        $linter = new Linter($config->getRules());

        $result = $this->getLinterRunner($config)->run($linter);

        $style = new SymfonyStyle($input, $output);

        $style->comment($result->getState());

        /** @var LintError $error */
        foreach ($result->errors as $error) {
            $style->error($error->description);
        }

        $style->info('Duration: '. $result->duration);

        return $result->isFail() ? 1 : 0;
    }

    protected function getLinterRunner(Config $config): LinterRunner
    {
        return new LinterRunner(
            new CiDetector(),
            new RequestFetcher(
                new SystemFactory($config->getCredentials()),
            ),
        );
    }
}
