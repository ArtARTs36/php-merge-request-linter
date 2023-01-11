<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data\Diff;

use ArtARTs36\Str\Str;

class DiffMapper
{
    /**
     * @param array<string> $response
     * @return array<Line>
     */
    public function map(array $response): array
    {
        $diff = [];

        foreach ($response as $respDiff) {
            $respDiffStr = Str::make($respDiff)->trim();

            /** @var Str $respLine */
            foreach ($respDiffStr->lines() as $respLine) {
                $type = Type::NOT_CHANGES;

                if ($respLine->startsWith('+')) {
                    $type = Type::NEW;
                    $respLine = $respLine->cut(null, start: 1);
                } elseif ($respLine->startsWith('-')) {
                    $type = Type::OLD;
                    $respLine = $respLine->cut(null, start: 1);
                }

                $diff[] = new Line(
                    $type,
                    $respLine,
                );
            }
        }

        return $diff;
    }
}
