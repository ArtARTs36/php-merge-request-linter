<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

final class CompositeRule implements Rule
{
    /**
     * @param non-empty-list<Rule> $rules
     */
    private function __construct(
        private iterable $rules,
    ) {
        //
    }

    /**
     * @param list<Rule> $rules
     */
    public static function make(array $rules): self
    {
        if (count($rules) === 0) {
            throw new \InvalidArgumentException(sprintf('Argument "rules" must not be empty'));
        }

        return new self($rules);
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
