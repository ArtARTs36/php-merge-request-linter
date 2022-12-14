<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Support\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EqualsOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'target_branch' => 'dev',
                ]),
                'targetBranch',
                'dev',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(MergeRequest $request, string $property, string $equals, bool $expected): void
    {
        $operator = new EqualsOperator(
            new PropertyExtractor(),
            $property,
            $equals,
        );

        self::assertEquals($expected, $operator->evaluate($request));
    }
}
