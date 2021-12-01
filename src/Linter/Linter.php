<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class Linter
{
    protected Rules $rules;

    public function __construct(?Rules $rules = null)
    {
        $this->rules = $rules ?? new Rules();
    }

    public function addRule(Rule ...$rules): self
    {
        foreach ($rules as $rule) {
            $this->rules->add($rule);
        }

        return $this;
    }

    public function run(MergeRequest $request): LintErrors
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            try {
                array_push($errors, ...$rule->lint($request));
            } catch (StopLintException $e) {
                $errors[] = new LintError('Lint stopped. Reason: '. $e->getMessage());

                break;
            } catch (\Throwable $e) {
                $errors[] = new LintError($e->getMessage());
            }
        }

        return new LintErrors($errors);
    }
}
