<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Value;

use ArtARTs36\FileSystem\Contracts\FileSystem;

final class FileTransformer extends StringFuncTransformer
{
    protected const FUNC_NAME = 'file';

    public function __construct(
        private readonly FileSystem $files,
    ) {
        //
    }

    protected function doTransform(string $preparedValue): string
    {
        return $this->files->getFileContent($preparedValue);
    }
}
