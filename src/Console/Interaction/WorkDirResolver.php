<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

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
        return $input->hasOption(self::OPTION_NAME) ?
            (string) $input->getOption(self::OPTION_NAME) :
            null;
    }
}
