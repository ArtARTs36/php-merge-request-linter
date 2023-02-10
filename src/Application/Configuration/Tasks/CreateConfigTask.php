<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\Tasks;

use ArtARTs36\MergeRequestLinter\Common\File\Directory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\ConfigFormat;

class CreateConfigTask
{
    public function __construct(
        public readonly ConfigFormat $format,
        public readonly Directory $targetDir
    ) {
        //
    }
}
