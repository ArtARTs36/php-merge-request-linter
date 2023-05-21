<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\InvalidEvaluatorValueException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsHeadingEvaluatorCreatorTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            ['containsHeading1', 'title', 1],
            ['containsHeading2', 'title', 2],
            ['containsHeading3', 'title', 3],
            ['containsHeading4', 'title', 4],
            ['containsHeading5', 'title', 5],
            ['containsHeading6', 'title', 6],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::extractHeadingLevel
     * @dataProvider providerForTestCreate
     */
    public function testCreate(string $evaluatorName, string $value, int $expectedLevel): void
    {
        $creator = new ContainsHeadingEvaluatorCreator();

        $result = $creator->create($evaluatorName, $value);

        self::assertInstanceOf(ContainsHeadingEvaluator::class, $result);
        self::assertEquals($expectedLevel, $result->level());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::create
     */
    public function testCreateOnNull(): void
    {
        $creator = new ContainsHeadingEvaluatorCreator();

        self::assertNull($creator->create('non-supported-type', 1));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::extractHeadingLevel
     */
    public function testCreateOnEvaluatorNotFound(): void
    {
        $creator = new ContainsHeadingEvaluatorCreator();

        self::expectException(ConditionEvaluatorNotFound::class);

        $creator->create('containsHeadingThree', '1');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ContainsHeadingEvaluatorCreator::create
     */
    public function testCreateOnInvalidValueType(): void
    {
        $creator = new ContainsHeadingEvaluatorCreator();

        self::expectException(InvalidEvaluatorValueException::class);

        $creator->create('containsHeading1', 1);
    }
}
