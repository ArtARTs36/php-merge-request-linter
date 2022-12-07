<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use Symfony\Component\Console\Input\InputOption;

trait HasConfigFileOption
{
    private function addConfigFileOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('config', mode: InputOption::VALUE_OPTIONAL));
    }
}
