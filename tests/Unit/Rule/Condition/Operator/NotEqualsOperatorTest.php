<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\NotEqualsOperator;
use ArtARTs36\MergeRequestLinter\Support\PropertyExtractor;
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
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\NotEqualsOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\NotEqualsOperator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\NotEqualsOperator::__construct
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
