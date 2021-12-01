<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class HasLabelsRule implements Rule
{
    /**
     * @param array<string> $labels
     */
    public function __construct(protected array $labels)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        if ((count($this->labels) === 0 && $request->labels->isEmpty()) || $request->labels->isEmpty()) {
            return [new LintNote('Required labels')];
        }

        return [];
    }

    public function getDefinition(): string
    {
        return "Merge must have labels: [". implode(',', $this->labels) . "]";
    }
}
