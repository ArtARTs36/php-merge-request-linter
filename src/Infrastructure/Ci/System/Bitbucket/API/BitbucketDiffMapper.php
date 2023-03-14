<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\Str\Str;

class BitbucketDiffMapper
{
    private const FILE_BREAK_LINE_START = 'diff --git';
    private const FILE_UNLESS_PREFIX = 'b/';
    private const FILE_UNLESS_PREFIX_LENGTH = 2;

    public function __construct(
        private readonly DiffMapper $mapper = new DiffMapper(),
    )
    {
        //
    }

    /**
     * @return array<string, array<DiffLine>>
     */
    public function map(string $response): array
    {
        $diff = [];

        $oldPath = null;
        $newPath = null;

        $change = Str::fromEmpty();
        $lines = Str::make($response)->lines();
        $lastIndex = count($lines) - 1;

        /** @var Str $line */
        foreach ($lines as $index => $line) {
            if ($oldPath === null && $line->startsWith('---')) {
                // 4 = "---" + space
                $oldPath = $line->cut(null, 4);
            } else if ($newPath === null && $line->startsWith('+++')) {
                // 4 = "---" + space
                $newPath = $line->cut(null, 4);

                if ($newPath->startsWith(self::FILE_UNLESS_PREFIX)) {
                    $newPath = $newPath->cut(null, self::FILE_UNLESS_PREFIX_LENGTH);
                }
            } else if ($change->isNotEmpty() && $line->startsWith(self::FILE_BREAK_LINE_START) || $index === $lastIndex) {
                foreach ($this->mapper->map([$change]) as $diffLine) {
                    $diff[(string) $newPath][] = $diffLine;
                }

                $change = Str::fromEmpty();
                $newPath = null;
                $oldPath = null;
            } else if ($oldPath !== null && $newPath !== null) {
                $change = $change->appendLine($line);
            }
        }

        return $diff;
    }
}
