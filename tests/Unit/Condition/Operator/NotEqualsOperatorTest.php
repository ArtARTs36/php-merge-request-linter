<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotEqualsOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'dev',
                'master',
                true,
            ],
            [
                'dev',
                'dev',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $propertyValue, string $notEquals, bool $expected): void
    {
        $operator = new NotEqualsOperator(
            new MockPropertyExtractor($propertyValue),
            $propertyValue,
            $notEquals,
        );

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
