<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait HasConfigFileOption
{
    abstract protected function getWorkDir(InputInterface $input): string;

    private function addConfigFileOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('config', mode: InputOption::VALUE_OPTIONAL));
    }
}
