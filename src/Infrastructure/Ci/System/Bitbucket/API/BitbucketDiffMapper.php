<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\Str\Str;

class BitbucketDiffMapper
{
    private const FILE_BREAK_LINE_START = 'diff --git';
    private const FILE_UNLESS_PREFIX = 'b/';
    private const FILE_UNLESS_PREFIX_LENGTH = 2;

    public function __construct(
        private readonly DiffMapper $mapper = new DiffMapper(),
    ) {
    }

    /**
     * @return array<string, Diff>
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
            } elseif ($newPath === null && $line->startsWith('+++')) {
                // 4 = "---" + space
                $newPath = $line->cut(null, 4);

                if ($newPath->startsWith(self::FILE_UNLESS_PREFIX)) {
                    $newPath = $newPath->cut(null, self::FILE_UNLESS_PREFIX_LENGTH);
                }
            } elseif ($change->isNotEmpty() && $line->startsWith(self::FILE_BREAK_LINE_START)) {
                $diff[(string) $newPath] = $this->mapper->map($change);

                $change = Str::fromEmpty();
                $newPath = null;
                $oldPath = null;
            } elseif ($oldPath !== null && $newPath !== null) {
                $change = $change->appendLine($line);

                if ($index === $lastIndex) {
                    $diff[(string) $newPath] = $this->mapper->map($change);
                }
            }
        }

        return $diff;
    }
}
