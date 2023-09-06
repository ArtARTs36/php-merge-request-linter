<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\TaskHandlers;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\DumpInfo;
use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Application\Rule\Tasks\DumpTask;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver;

class DumpTaskHandler
{
    public function __construct(
        private readonly ConfigResolver $config,
        private readonly RuleDumper $dumper,
    ) {
    }

    public function handle(DumpTask $task): DumpInfo
    {
        $config = $this
            ->config
            ->resolve(new User($task->workingDirectory, $task->customConfigPath), Config::SUBJECT_RULES);

        return new DumpInfo($config->path, $this->dumper->dump($config->config->getRules()));
    }
}
