<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\InvalidConfigValueException;

final class FileTransformer extends StringFuncTransformer
{
    protected const FUNC_NAME = 'file';

    public function __construct(
        private readonly FileSystem $files,
    ) {
    }

    protected function doTransform(string $preparedValue): string
    {
        try {
            return $this->files->getFileContent($preparedValue);
        } catch (FileNotFound $e) {
            throw new InvalidConfigValueException($e->getMessage(), previous: $e);
        }
    }
}
