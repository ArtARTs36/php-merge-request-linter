<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers;

use ArtARTs36\MergeRequestLinter\Application\Configuration\TaskHandlers\CreateConfigTask;
use ArtARTs36\MergeRequestLinter\Shared\File\File;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Copier;

class CreateConfigTaskHandler
{
    public function __construct(
        private readonly Copier $copier,
    ) {
        //
    }

    public function handle(CreateConfigTask $task): File
    {
        return $this->copier->copy($task->format, $task->targetDir);
    }
}
