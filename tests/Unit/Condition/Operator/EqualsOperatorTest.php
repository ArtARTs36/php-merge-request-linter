<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\CallbackPropertyExtractor;
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
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(MergeRequest $request, string $property, string $equals, bool $expected): void
    {
        $operator = new EqualsOperator(
            new CallbackPropertyExtractor(),
            $property,
            $equals,
        );

        self::assertEquals($expected, $operator->evaluate($request));
    }
}
