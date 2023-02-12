<?php

namespace ArtARTs36\MergeRequestLinter\Shared\File;

class Directory
{
    public function __construct(
        private readonly string $directory,
    ) {
        //
    }

    public function pathTo(string $filename): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $filename;
    }

    public function __toString(): string
    {
        return $this->directory;
    }
}
