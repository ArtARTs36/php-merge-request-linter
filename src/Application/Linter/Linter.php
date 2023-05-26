<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\EvaluatorCrashedException;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintStartedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleFatalEndedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
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
        protected Rules           $rules,
        protected LinterOptions   $options,
        protected EventDispatcherInterface $events,
        private readonly MetricManager     $metrics,
    ) {
        //
    }

    public function run(MergeRequest $request): LintResult
    {
        $timer = Timer::start();

        $this->addMetricUsedRules();

        $this->events->dispatch(new LintStartedEvent($request));

        $notes = [];

        $ok = true;
        $risky = false;

        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            try {
                $ruleNotes = $rule->lint($request);

                foreach ($ruleNotes as $ruleNote) {
                    $notes[] = $ruleNote;

                    if ($ruleNote->getSeverity() === NoteSeverity::Warning) {
                        $risky = true;
                    } else {
                        $ok = false;
                    }
                }

                $this->dispatchRuleEvent($rule, $ruleNotes);

                if ($this->options->stopOnFirstFailure && ! $ok) {
                    break;
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
        $result = new LintResult($this->createState($ok, $risky), $notes, $duration);

        $this->events->dispatch(new LintFinishedEvent($request, $result));

        return $result;
    }

    private function addMetricUsedRules(): void
    {
        $this->metrics->add(
            new MetricSubject(
                'linter_used_rules',
                '[Linter] Used rules',
            ),
            IncCounter::create($this->rules),
        );
    }

    /**
     * @param array<Note> $notes
     */
    private function dispatchRuleEvent(Rule $rule, array $notes): void
    {
        if (count($notes) === 0) {
            $this->events->dispatch(new RuleWasSuccessfulEvent($rule->getName()));
        } else {
            $this->events->dispatch(new RuleWasFailedEvent($rule->getName(), $notes));
        }
    }

    private function createState(bool $ok, bool $risky): LintState
    {
        if (! $ok) {
            return LintState::Fail;
        }

        if ($risky) {
            return LintState::Risky;
        }

        return LintState::Success;
    }
}
