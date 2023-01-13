<?php

namespace ArtARTs36\MergeRequestLinter\Console\Command;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Configuration\User;
use ArtARTs36\MergeRequestLinter\Console\Interaction\WorkDirResolver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait HasConfigFileOption
{
    private function addConfigFileOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('config', mode: InputOption::VALUE_OPTIONAL));

        $this
            ->getDefinition()
            ->addOption(new InputOption(WorkDirResolver::OPTION_NAME, mode: InputOption::VALUE_OPTIONAL));
    }

    /**
     * @throws \Exception
     */
    private function resolveConfig(InputInterface $input): ResolvedConfig
    {
        $customPath = $input->getOption('config');

        $currentDir = (new WorkDirResolver())->resolve($input);

        return $this->config->resolve(new User($currentDir, $customPath));
    }
}
