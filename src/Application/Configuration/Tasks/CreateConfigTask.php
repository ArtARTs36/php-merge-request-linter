<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\Tasks;

use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;

/**
 * @codeCoverageIgnore
 */
class CreateConfigTask
{
    public function __construct(
        public readonly ConfigFormat $format,
        public readonly Directory $targetDir
    ) {
        //
    }
}
