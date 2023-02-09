<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\LintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Notes;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\InvalidEvaluatorValueException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
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
        $this->eventSubscriber->started($request);

        $notes = [];

        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            try {
                array_push($notes, ...$rule->lint($request));

                $this->eventSubscriber->success($rule->getName());
            } catch (StopLintException $e) {
                $notes[] = new LintNote(sprintf('[%s] Lint stopped. Reason: %s', $rule->getName(), $e->getMessage()));

                $this->eventSubscriber->stopOn($rule->getName());

                break;
            } catch (InvalidEvaluatorValueException $e) {
                $notes[] = new LintNote(sprintf('[%s] Invalid condition value: %s', $rule->getName(), $e->getMessage()));
            } catch (\Throwable $e) {
                $notes[] = new ExceptionNote($e);

                $this->eventSubscriber->fail($rule->getName());
            }
        }

        return new Notes($notes);
    }
}
