<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration;

use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Shared\File\File;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;

class Copier
{
    public function __construct(
        private readonly Directory $stubsDir,
    ) {
    }

    public function copy(ConfigFormat $format, Directory $targetDir): File
    {
        $stubsPath = $this->stubsDir->pathTo(sprintf('.mr-linter.%s', $format->value));
        $targetPath = $targetDir->pathTo(sprintf('.mr-linter.%s', $format->value));

        copy($stubsPath, $targetPath);

        return new File($targetPath);
    }
}
