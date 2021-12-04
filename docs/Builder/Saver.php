<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

class Saver
{
    /**
     * @return bool - has changes
     */
    public function save(string $path, string $content): bool
    {
        $prevHash = file_exists($path) ? md5_file($path) : null;

        file_put_contents($path, $content);

        return $prevHash !== md5_file($path);
    }
}
