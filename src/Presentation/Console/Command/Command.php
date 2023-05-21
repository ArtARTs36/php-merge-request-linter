<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Exceptions\InvalidInputException;
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

    final protected function getStringOptionFromInput(InputInterface $input, string $key): ?string
    {
        $option = $input->getOption($key);

        if ($option === null) {
            return null;
        }

        if (! is_string($option)) {
            throw new InvalidInputException(sprintf('Input option "%s" must be string', $key));
        }

        return $option;
    }

    final protected function getBoolFromOption(InputInterface $input, string $key, bool $default = false): bool
    {
        $option = $input->getOption($key);

        if ($option === null) {
            return $default;
        }

        if (! is_bool($option)) {
            throw new \RuntimeException(sprintf('Input option "%s" must be bool', $key));
        }

        return $option;
    }

    private function addWorkDirOption(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption(WorkDirResolver::OPTION_NAME, mode: InputOption::VALUE_OPTIONAL));
    }
}
