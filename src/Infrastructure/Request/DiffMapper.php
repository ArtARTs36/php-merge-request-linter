<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\Str\Str;

class DiffMapper
{
    /**
     * @param array<string> $response
     * @return array<DiffLine>
     */
    public function map(array $response): array
    {
        $diff = [];

        foreach ($response as $respDiff) {
            $respDiffStr = Str::make($respDiff)->trim();

            /** @var Str $respLine */
            foreach ($respDiffStr->lines() as $respLine) {
                $type = DiffType::NOT_CHANGES;

                if ($respLine->startsWith('+')) {
                    $type = DiffType::NEW;
                    $respLine = $respLine->cut(null, start: 1);
                } elseif ($respLine->startsWith('-')) {
                    $type = DiffType::OLD;
                    $respLine = $respLine->cut(null, start: 1);
                }

                $diff[] = new DiffLine(
                    $type,
                    $respLine,
                );
            }
        }

        return $diff;
    }
}
