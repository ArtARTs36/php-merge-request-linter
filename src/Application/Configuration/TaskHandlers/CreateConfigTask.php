<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\TaskHandlers;

use ArtARTs36\MergeRequestLinter\Common\File\Directory;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;

class CreateConfigTask
{
    public function __construct(
        public readonly ConfigFormat $format,
        public readonly Directory $targetDir
    ) {
        //
    }
}
