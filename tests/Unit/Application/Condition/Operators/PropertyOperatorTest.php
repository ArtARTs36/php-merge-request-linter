<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Operators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Operators\PropertyOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PropertyOperatorTest extends TestCase
{
    public function providerForTestCheck(): array
    {
        return [
            [
                MockConditionEvaluator::success(),
                new MockEvaluatingSubjectFactory(new MockEvaluatingSubject('val')),
                true,
            ],
            [
                MockConditionEvaluator::failed(),
                new MockEvaluatingSubjectFactory(new MockEvaluatingSubject('val')),
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Operators\PropertyOperator::check
     * @dataProvider providerForTestCheck
     */
    public function testCheck(ConditionEvaluator $evaluator, EvaluatingSubjectFactory $subjectFactory, bool $expected): void
    {
        $operator = new PropertyOperator($evaluator, $subjectFactory, 'prop');

        self::assertEquals($expected, $operator->check(new \stdClass()));
    }
}
