<?php

namespace ArtARTs36\MergeRequestLinter\Console;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Configuration\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait HasConfigFileOption
{
    private function addConfigFileOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('config', mode: InputOption::VALUE_OPTIONAL));
    }

    /**
     * @throws \Exception
     */
    private function resolveConfig(InputInterface $input): ResolvedConfig
    {
        $customPath = $input->getOption('config');

        $currentDir = getcwd();

        if ($currentDir === false) {
            throw new \Exception('Current directory didnt defined');
        }

        return $this->config->resolve(new User($currentDir, $customPath));
    }
}
