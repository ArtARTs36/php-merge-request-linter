<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;
use JetBrains\PhpStorm\ArrayShape;

class MergeRequest
{
    /**
     * @param Map<string, string> $labels
     */
    public function __construct(
        public Str $title,
        public Str $description,
        public Map $labels,
        public bool $hasConflicts,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function fromArray(
        #[ArrayShape([
            'title' => 'string',
            'description' => 'string',
            'labels' => 'array',
            'has_conflicts' => 'bool',
        ])]
        array $request
    ): self {
        return new self(
            Str::make($request['title']),
            Str::make($request['description']),
            Map::fromList($request['labels']),
            (bool) $request['has_conflicts'],
        );
    }
}
