<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Tasks\CreateConfigTask;
use ArtARTs36\MergeRequestLinter\Common\File\File;
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
