<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class Linter
{
    protected Rules $rules;

    public function __construct(?Rules $rules = null)
    {
        $this->rules = $rules ?? new Rules();
    }

    public function addRule(Rule $rule): self
    {
        $this->rules->add($rule);

        return $this;
    }

    public function run(MergeRequest $request): LintErrors
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->lint($request));
        }

        return new LintErrors($errors);
    }
}
