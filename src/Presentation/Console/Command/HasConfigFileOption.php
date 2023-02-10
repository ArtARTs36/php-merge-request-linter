<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
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

    /**
     * @throws \Exception
     */
    private function resolveConfig(InputInterface $input): ResolvedConfig
    {
        return $this
            ->config
            ->resolve(
                new User(
                    $this->getWorkDir($input),
                    $input->getOption('config'),
                )
            );
    }
}
