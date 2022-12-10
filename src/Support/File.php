<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class File
{
    public static function extension(string $path): string
    {
        return mb_strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
