<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotStartsAnyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'Artem',
                [
                    'Art',
                    'eewew',
                ],
                false,
            ],
            [
                'eefcefcecfe',
                [
                    'Artem1',
                    'eewew',
                ],
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsAnyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsAnyEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsAnyEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $propertyValue, array $value, bool $expected): void
    {
        $operator = new NotStartsAnyEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
