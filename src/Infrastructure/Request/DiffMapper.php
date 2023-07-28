<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Request;

use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\Str\Str;

class DiffMapper
{
    public function map(string $patch): Diff
    {
        $fragments = [
            DiffType::OLD->value => [],
            DiffType::NEW->value => [],
            DiffType::NOT_CHANGES->value => [],
            'all' => [],
        ];

        $fragmentContent = Str::fromEmpty();
        $linesCollection = Str::make($patch)->lines();
        $lastLineIndex = $linesCollection->count() - 1;

        $prevType = null;

        foreach ($linesCollection as $currentIndex => $respLine) {
            $type = DiffType::NOT_CHANGES;

            if ($respLine->startsWith('+')) {
                $type = DiffType::NEW;
                $respLine = $respLine->cut(null, start: 1);
            } elseif ($respLine->startsWith('-')) {
                $type = DiffType::OLD;
                $respLine = $respLine->cut(null, start: 1);
            }

            if ($prevType === null) {
                $prevType = $type;

                $fragmentContent = $respLine;

                continue;
            } else if ($prevType === $type) {
                $fragmentContent = $fragmentContent->appendLine($respLine);

                continue;
            }

            $fragment = new DiffFragment($prevType, $fragmentContent);

            $fragments[$prevType->value][] = $fragment;
            $fragments['all'][] = $fragment;

            $fragmentContent = $respLine;
            $prevType = $type;

            if ($currentIndex === $lastLineIndex) {
                $fragment = new DiffFragment($prevType, $fragmentContent);

                $fragments[$type->value][] = $fragment;
                $fragments['all'][] = $fragment;
            }
        }

        return new Diff(
            new Arrayee($fragments[DiffType::OLD->value]),
            new Arrayee($fragments[DiffType::NEW->value]),
            new Arrayee($fragments[DiffType::NOT_CHANGES->value]),
            new Arrayee($fragments['all']),
        );
    }
}
