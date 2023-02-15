<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\WorkDirResolver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    public function __construct()
    {
        parent::__construct();

        $this->addWorkDirOption();
    }

    final protected function getWorkDir(InputInterface $input): string
    {
        return (new WorkDirResolver())->resolve($input);
    }

    private function addWorkDirOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption(WorkDirResolver::OPTION_NAME, mode: InputOption::VALUE_OPTIONAL));
    }
}
