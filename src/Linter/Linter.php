<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class Linter
{
    public function __construct(protected Rules $rules)
    {
        //
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
