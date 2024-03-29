<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\EvaluatorCrashedException;
use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleFatalEndedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\ExceptionRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\FailRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\WarningNote;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\WarningRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\AnyInvokedCount;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class LinterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::__construct
     */
    public function testRunOnException(): void
    {
        $linter = new Linter(
            new Rules([
                $this->createExceptionRule(),
            ]),
            new LinterOptions(false),
            new NullEventDispatcher(),
            new NullMetricManager(),
        );

        $result = $linter->run($this->makeMergeRequest());

        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }

    private function createExceptionRule(): Rule
    {
        return new class () implements Rule {
            public function getName(): string
            {
                return 'anonymous_rule';
            }

            public function lint(MergeRequest $request): array
            {
                throw new \RuntimeException();
            }

            public function getDefinition(): RuleDefinition
            {
                return new Definition('');
            }
        };
    }

    public function providerForTestRun(): array
    {
        return [
            'test success result' => [
                'rules' => new Rules([
                    new SuccessRule(),
                    new SuccessRule(),
                ]),
                new LinterOptions(false),
                [
                    new RuleWasSuccessfulEvent('success_rule'),
                    new RuleWasSuccessfulEvent('success_rule'),
                ],
                new LintResult(LintState::Success, new Arrayee([]), new Duration(1)),
            ],
            'test success result with warnings' => [
                'rules' => new Rules([
                    new SuccessRule(),
                    new WarningRule('warning_note'),
                    new SuccessRule(),
                ]),
                new LinterOptions(false),
                [
                    new RuleWasSuccessfulEvent('success_rule'),
                    new RuleWasFailedEvent('warning_rule', [
                        new WarningNote('warning_note'),
                    ]),
                    new RuleWasSuccessfulEvent('success_rule'),
                ],
                new LintResult(LintState::Success, new Arrayee([
                    new WarningNote('warning_note'),
                ]), new Duration(1)),
            ],
            'test exception note' => [
                'rules' => new Rules([
                    new ExceptionRule('exception msg'),
                ]),
                new LinterOptions(false),
                [
                    new RuleFatalEndedEvent('exception_rule'),
                ],
                new LintResult(LintState::Fail, new Arrayee([
                    new ExceptionNote(new \Exception('exception msg')),
                ]), new Duration(1))
            ],
            'test stop on first warning' => [
                'rules' => new Rules([
                    new WarningRule('warning_note'),
                    new WarningRule('warning_note2'),
                    new SuccessRule(),
                ]),
                new LinterOptions(false, true),
                [
                    new RuleWasFailedEvent('warning_rule', [
                        new WarningNote('warning_note'),
                    ]),
                ],
                new LintResult(LintState::Success, new Arrayee([
                    new WarningNote('warning_note'),
                ]), new Duration(1)),
            ],
            'test stop on first failure' => [
                'rules' => new Rules([
                    new FailRule(),
                    new FailRule(),
                ]),
                new LinterOptions(true),
                [
                    new RuleWasFailedEvent('fail_rule', [
                        new EmptyNote(''),
                    ]),
                ],
                new LintResult(LintState::Fail, new Arrayee([
                    new EmptyNote(''),
                ]), new Duration(1)),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::addMetricUsedRules
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::dispatchRuleEvent
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::createState
     * @dataProvider providerForTestRun
     */
    public function testRun(Rules $rules, LinterOptions $options, array $expectedEvents, LintResult $expectedResult): void
    {
        $eventDispatcher = new MockEventDispatcher();

        $linter = new Linter(
            $rules,
            $options,
            $eventDispatcher,
            new NullMetricManager(),
        );

        $result = $linter->run($this->makeMergeRequest());

        $eventDispatcher->assertDispatchedObjectList($expectedEvents);

        self::assertEquals(
            [
                'state' => $expectedResult->state,
                'notes' => $expectedResult->notes,
            ],
            [
                'state' => $result->state,
                'notes' => $result->notes,
            ],
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::run
     */
    public function testRunOnEvaluatorCrashedException(): void
    {
        $eventDispatcher = new MockEventDispatcher();

        $evaluatorCrashedRule = $this->createMock(Rule::class);
        $evaluatorCrashedRule
            ->expects(new AnyInvokedCount())
            ->method('getName')
            ->willReturn('failed_rule');
        $evaluatorCrashedRule
            ->expects(new InvokedCount(1))
            ->method('lint')
            ->willThrowException(new EvaluatorCrashedException());

        $linter = new Linter(
            new Rules([
                $evaluatorCrashedRule,
            ]),
            new LinterOptions(),
            $eventDispatcher,
            new NullMetricManager(),
        );

        $gotLintResult = $linter->run($this->makeMergeRequest());

        $eventDispatcher->assertDispatchedObject(new RuleFatalEndedEvent('failed_rule'));

        self::assertFalse($gotLintResult->notes->isEmpty());

        self::assertStringContainsString('Invalid condition value', $gotLintResult->notes->first()->getDescription());
    }
}
