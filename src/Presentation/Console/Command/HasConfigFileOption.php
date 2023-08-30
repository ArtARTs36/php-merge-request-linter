<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use Symfony\Component\Console\Input\InputOption;

trait HasConfigFileOption
{
    private function addConfigFileOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('config', mode: InputOption::VALUE_OPTIONAL, description: 'Path to config'));
    }
}
