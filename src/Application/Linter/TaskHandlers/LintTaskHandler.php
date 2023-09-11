<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\TaskHandlers;

use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\Tasks\LintTask;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Linter\LinterRunnerFactory;
use Psr\EventDispatcher\EventDispatcherInterface;

class LintTaskHandler
{
    public function __construct(
        private readonly ConfigResolver $config,
        private readonly EventDispatcherInterface $events,
        private readonly LinterFactory $linterFactory,
        private readonly LinterRunnerFactory $runnerFactory,
    ) {
    }

    public function handle(LintTask $task): LintResult
    {
        $config = $this->config->resolve(
            new User(
                $task->workingDirectory,
                $task->customPath,
            ),
        );

        $this->events->dispatch(new ConfigResolvedEvent($config));

        return $this
            ->createLinterRunner($config)
            ->run($this->linterFactory->create($config->config));
    }

    private function createLinterRunner(ResolvedConfig $config): LinterRunner
    {
        return $this->runnerFactory->create(
            $config->config,
        );
    }
}
