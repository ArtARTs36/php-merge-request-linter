<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

final class CompositeRule implements Rule
{
    /**
     * @param iterable<Rule> $rules
     */
    public function __construct(
        private iterable $rules,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->rules as $rule) {
            array_push($notes, ...$rule->lint($request));
        }

        return $notes;
    }

    public function getName(): string
    {
        return reset($this->rules)->getName();
    }

    public function getDefinition(): RuleDefinition
    {
        return reset($this->rules)->getDefinition();
    }
}
