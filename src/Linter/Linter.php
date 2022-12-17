<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\LintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class Linter
{
    public function __construct(
        protected Rules $rules,
        protected LintEventSubscriber $eventSubscriber,
    ) {
        //
    }

    public function run(MergeRequest $request): Notes
    {
        $notes = [];

        foreach ($this->rules as $rule) {
            try {
                array_push($notes, ...$rule->lint($request));

                $this->eventSubscriber->success($rule->getName());
            } catch (StopLintException $e) {
                $notes[] = new LintNote('Lint stopped. Reason: '. $e->getMessage());

                $this->eventSubscriber->stopOn($rule->getName());

                break;
            } catch (\Throwable $e) {
                $notes[] = new ExceptionNote($e);

                $this->eventSubscriber->fail($rule->getName());
            }
        }

        return new Notes($notes);
    }
}
