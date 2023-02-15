<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Generic;

use ArtARTs36\EmptyContracts\MayBeEmpty;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\IsEmptyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsEmptyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                new class () implements MayBeEmpty {
                    public function isEmpty(): bool
                    {
                        return true;
                    }
                },
                true,
                true,
            ],
            [
                new class () implements MayBeEmpty {
                    public function isEmpty(): bool
                    {
                        return true;
                    }
                },
                false,
                false,
            ],
            [
                new class () implements MayBeEmpty {
                    public function isEmpty(): bool
                    {
                        return false;
                    }
                },
                false,
                true,
            ],
            [
                new class () implements MayBeEmpty {
                    public function isEmpty(): bool
                    {
                        return false;
                    }
                },
                true,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\IsEmptyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\IsEmptyEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(MayBeEmpty $subject, bool $evaluatorValue, bool $expectedResult): void
    {
        $evaluator = new IsEmptyEvaluator($evaluatorValue);

        self::assertEquals($expectedResult, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
