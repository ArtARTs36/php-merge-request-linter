<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction;

use Symfony\Component\Console\Input\InputInterface;

class WorkDirResolver
{
    public const OPTION_NAME = 'work-dir';

    public function resolve(InputInterface $input): string
    {
        $inputDir = $this->getFromInput($input);

        if ($inputDir !== null) {
            return $inputDir;
        }

        $cwd = getcwd();

        if ($cwd === false) {
            throw new \RuntimeException('Current work directory not resolved');
        }

        return $cwd;
    }

    private function getFromInput(InputInterface $input): ?string
    {
        $option = $input->getOption(self::OPTION_NAME);

        if (empty($option)) {
            return null;
        }

        if (! is_string($option)) {
            throw new \RuntimeException(sprintf('Option "%s" must be string', self::OPTION_NAME));
        }

        return $option;
    }
}
