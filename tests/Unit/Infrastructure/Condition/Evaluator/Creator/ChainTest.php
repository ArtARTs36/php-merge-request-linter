<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\Chain;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChainTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\Chain::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\Chain::add
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\Chain::__construct
     */
    public function testCreate(): void
    {
        $chain = new Chain();

        self::assertNull($chain->create('', ''));

        $chain->add(new MockEvaluatorCreator($expectedEvaluator = MockConditionEvaluator::success()));

        self::assertEquals($expectedEvaluator, $chain->create('', ''));
    }
}
