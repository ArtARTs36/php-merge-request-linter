<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

abstract class AbstractDecorateRule implements Rule
{
    /**
     * @param array<Rule> $decorateRules
     */
    public function __construct(protected array $decorateRules)
    {
        //
    }

    /**
     * @return array<int, Note>
     */
    protected function runLintOnDecorateRules(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->decorateRules as $rule) {
            array_push($notes, ...$rule->lint($request));
        }

        return array_filter($notes);
    }
}
