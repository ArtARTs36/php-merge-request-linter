<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\IsNumberEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsNumberEvaluatorTest extends TestCase
{
    public static function providerForTestEvaluate(): array
    {
        return [
            // empty string
            'check empty string on number' => [
                'value' => true,
                'propertyValue' => '',
                'expected' => false,
            ],
            'check empty string on no number' => [
                'value' => false,
                'propertyValue' => '',
                'expected' => true,
            ],
            // string of integer
            'check string of integer on number' => [
                'value' => true,
                'propertyValue' => '1',
                'expected' => true,
            ],
            'check string of integer on no number' => [
                'value' => false,
                'propertyValue' => '1',
                'expected' => false,
            ],
            // check string starts with integer on number
            'check string starts with integer on number' => [
                'value' => true,
                'propertyValue' => '1a',
                'expected' => false,
            ],
            'check string starts with integer on no number' => [
                'value' => false,
                'propertyValue' => '1a',
                'expected' => true,
            ],
            // check string of float on number
            'check string of float on number' => [
                'value' => true,
                'propertyValue' => '1.0',
                'expected' => true,
            ],
            'check string of float on no number' => [
                'value' => false,
                'propertyValue' => '1.0',
                'expected' => false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\IsNumberEvaluator::doEvaluate
     *
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(bool $value, string $propertyValue, bool $expected): void
    {
        $evaluator = new IsNumberEvaluator($value);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
