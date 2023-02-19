<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\SimpleCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SimpleCreatorTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [
                [
                    'test' => TestEvaluatorForSimpleCreator::class,
                ],
                'test',
                'null',
                TestEvaluatorForSimpleCreator::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\SimpleCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\SimpleCreator::__construct
     * @dataProvider providerForTestCreate
     */
    public function testCreate(array $evaluators, string $type, mixed $value, string $expectedEvaluatorClass): void
    {
        $creator = new SimpleCreator(new ArrayMap($evaluators));

        $result = $creator->create($type, $value);

        self::assertInstanceOf($expectedEvaluatorClass, $result);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\SimpleCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\SimpleCreator::__construct
     */
    public function testCreateOnEvaluatorNotFound(): void
    {
        $creator = new SimpleCreator(new ArrayMap([]));

        self::expectException(ConditionEvaluatorNotFound::class);

        $creator->create('test', 0);
    }
}

class TestEvaluatorForSimpleCreator implements ConditionEvaluator
{
    public function __construct(
        public readonly mixed $value,
    ) {
        //
    }

    public function evaluate(EvaluatingSubject $subject): bool
    {
        return true;
    }
}
