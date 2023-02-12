<?php

namespace ArtARTs36\MergeRequestLinter\Shared\File;

class File extends \SplFileInfo
{
    public function getSizeString(): string
    {
        $size = $this->getSize();

        if ($size === false) {
            return '';
        }

        return Bytes::toString($size);
    }

    public static function extension(string $path): string
    {
        return mb_strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
