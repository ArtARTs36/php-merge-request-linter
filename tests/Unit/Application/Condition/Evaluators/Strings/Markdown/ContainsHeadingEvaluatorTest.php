<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings\Markdown;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ContainsHeadingEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                '## Title',
                'Title',
                2,
                true,
            ],
            [
                '## Title',
                'Title',
                3,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subject, string $value, int $level, bool $expected): void
    {
        $evaluator = new ContainsHeadingEvaluator($value, $level);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject(Str::make($subject)->markdown())));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator::level
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator::__construct
     */
    public function testLevel(): void
    {
        $evaluator = new ContainsHeadingEvaluator('title', 5);

        self::assertEquals(5, $evaluator->level());
    }
}
