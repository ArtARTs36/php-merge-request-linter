<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class CompositeRule implements RuleDecorator
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
            throw new \InvalidArgumentException('Argument "rules" must not be empty');
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

    public function getDecoratedRules(): array
    {
        return $this->rules;
    }
}
