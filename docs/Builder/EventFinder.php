<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

class EventFinder
{
    public function find(): array
    {
        $files = $this->search(__DIR__ . '/../../src/', '/.*Event\.php/');
        $classes = [];

        foreach ($files as [$file]) {
            $tokens = token_get_all(file_get_contents($file));

            foreach ($tokens as $index => [$id, $value]) {
                if ($id !== T_NAMESPACE) {
                    continue;
                }

                $needToken = $tokens[$index + 2];

                if ($needToken[0] !== T_NAME_QUALIFIED) {
                    throw new \Exception();
                }

                $namespace = $needToken[1];

                $classes[] = $namespace . '\\' . pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $classes;
    }

    private function search(string $folder, string $regPattern): array
    {
        $dir = new \RecursiveDirectoryIterator($folder);
        $ite = new \RecursiveIteratorIterator($dir);
        $files = new \RegexIterator($ite, $regPattern, \RegexIterator::GET_MATCH);
        $fileList = [];

        foreach($files as $file) {
            $fileList[] = $file;
        }

        return $fileList;
    }
}
