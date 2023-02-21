<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Generic;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EqualsAnyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['dev', ['dev', 'devv'], true],
            ['dev1', ['dev'], false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subject, array $value, bool $expected): void
    {
        $operator = new EqualsAnyEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
