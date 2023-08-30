<?php

namespace ArtARTs36\MergeRequestLinter\Application\Configuration\Tasks;

use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;

/**
 * @codeCoverageIgnore
 */
readonly class CreateConfigTask
{
    public function __construct(
        public ConfigFormat $format,
        public Directory    $targetDir
    ) {
        //
    }
}
