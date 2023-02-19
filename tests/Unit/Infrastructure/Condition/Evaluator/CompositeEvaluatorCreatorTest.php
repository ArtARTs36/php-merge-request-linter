<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CompositeEvaluatorCreatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::__construct
     */
    public function testCreate(): void
    {
        $creator = new CompositeEvaluatorCreator(
            new SubjectFactory(new MockPropertyExtractor('')),
            new MockEvaluatorCreator(
                MockConditionEvaluator::success(),
            ),
            AllEvaluator::class,
        );

        self::assertInstanceOf(AllEvaluator::class, $creator->create(
            AllEvaluator::NAME,
            [['k' => 'v']],
        ));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::__construct
     */
    public function testConditionEvaluatorNotFound(): void
    {
        $creator = new CompositeEvaluatorCreator(
            new SubjectFactory(new MockPropertyExtractor('')),
            new MockEvaluatorCreator(null),
            AllEvaluator::class,
        );

        self::expectException(ConditionEvaluatorNotFound::class);

        $creator->create(
            AllEvaluator::NAME,
            [['k' => 'v']],
        );
    }

    public function providerForTestConditionOnNull(): array
    {
        return [
            [
                'type' => 'non-exists-evaluator',
                [],
            ],
            [
                'type' => AllEvaluator::NAME,
                0,
            ],
            [
                'type' => AllEvaluator::NAME,
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\CompositeEvaluatorCreator::__construct
     * @dataProvider providerForTestConditionOnNull
     */
    public function testConditionOnNull(string $type, mixed $value): void
    {
        $creator = new CompositeEvaluatorCreator(
            new SubjectFactory(new MockPropertyExtractor('')),
            new MockEvaluatorCreator(null),
            AllEvaluator::class,
        );

        self::assertNull($creator->create($type, $value));
    }
}
