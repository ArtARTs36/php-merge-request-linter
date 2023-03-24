<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\EvaluatorCrashedException;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintStartedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleFatalEndedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use Psr\EventDispatcher\EventDispatcherInterface;

class Linter implements \ArtARTs36\MergeRequestLinter\Domain\Linter\Linter
{
    public function __construct(
        protected Rules $rules,
        protected EventDispatcherInterface $events,
        private readonly MetricManager $metrics,
    ) {
        //
    }

    public function run(MergeRequest $request): LintResult
    {
        $timer = Timer::start();

        $this->metrics->add(
            new MetricSubject(
                'linter_used_rules',
                '[Linter] Used rules',
            ),
            IncCounter::create($this->rules),
        );

        $this->events->dispatch(new LintStartedEvent($request));

        $notes = [];

        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            try {
                $ruleNotes = $rule->lint($request);

                array_push($notes, ...$ruleNotes);

                if (count($ruleNotes) === 0) {
                    $this->events->dispatch(new RuleWasSuccessfulEvent($rule->getName()));
                } else {
                    $this->events->dispatch(new RuleWasFailedEvent($rule->getName()));
                }
            } catch (EvaluatorCrashedException $e) {
                $notes[] = new LintNote(sprintf('[%s] Invalid condition value: %s', $rule->getName(), $e->getMessage()));

                $this->events->dispatch(new RuleFatalEndedEvent($rule->getName()));
            } catch (\Throwable $e) {
                $notes[] = new ExceptionNote($e);

                $this->events->dispatch(new RuleFatalEndedEvent($rule->getName()));
            }
        }

        $duration = $timer->finish();

        $notes = new Arrayee($notes);
        $result = new LintResult($notes->isEmpty(), $notes, $duration);

        $this->events->dispatch(new LintFinishedEvent($request, $result));

        return $result;
    }
}
