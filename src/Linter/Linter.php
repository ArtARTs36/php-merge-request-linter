<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class Linter
{
    public function __construct(protected Rules $rules)
    {
        //
    }

    public function run(MergeRequest $request): Notes
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            try {
                array_push($errors, ...$rule->lint($request));
            } catch (StopLintException $e) {
                $errors[] = new LintNote('Lint stopped. Reason: '. $e->getMessage());

                break;
            } catch (\Throwable $e) {
                $errors[] = new ExceptionNote($e);
            }
        }

        return new Notes($errors);
    }
}
