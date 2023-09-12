<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotIntersectEvaluator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotIntersectEvaluatorTest extends TestCase
{
    public static function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                new Arrayee([]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([1]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([2]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([1, 3]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([2, 3]),
                true,
            ],
            [
                [1, 2],
                new Arrayee([1, 2]),
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotIntersectEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotIntersectEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotIntersectEvaluator::collectionContainsDifferentValues
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotIntersectEvaluator::__construct
     *
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $value, Collection $subject, bool $expected): void
    {
        $evaluator = new NotIntersectEvaluator($value);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
