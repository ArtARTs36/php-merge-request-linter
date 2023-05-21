<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConditionEvaluatorNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound::make
     */
    public function testMake(): void
    {
        $e = ConditionEvaluatorNotFound::make('hasItem');

        self::assertEquals(
            'Condition Operator with name "hasItem" not found',
            $e->getMessage(),
        );
    }
}
