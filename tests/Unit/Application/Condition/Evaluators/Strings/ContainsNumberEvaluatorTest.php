<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsNumberEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\IsNumberEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsNumberEvaluatorTest extends TestCase
{
    public static function providerForTestEvaluate(): array
    {
        return [
            // empty string
            'check empty string on true' => [
                'value' => true,
                'propertyValue' => '',
                'expected' => false,
            ],
            'check empty string on false' => [
                'value' => false,
                'propertyValue' => '',
                'expected' => true,
            ],
            // string of integer
            'check string of integer on true' =>[
                'value' => true,
                'propertyValue' => '1',
                'expected' => true,
            ],
            'check string of integer on false' =>[
                'value' => false,
                'propertyValue' => '1',
                'expected' => false,
            ],
            // check string starts with integer on number
            'check string starts with integer on true' => [
                'value' => true,
                'propertyValue' => '1a',
                'expected' => true,
            ],
            'check string starts with integer on false' => [
                'value' => false,
                'propertyValue' => '1a',
                'expected' => false,
            ],
            // check string ends with integer on number
            'check string ends with integer on true' => [
                'value' => true,
                'propertyValue' => 'a1',
                'expected' => true,
            ],
            'check string ends with integer on false' => [
                'value' => false,
                'propertyValue' => 'a1',
                'expected' => false,
            ],
            // check string of float on number
            'check string of float on true' => [
                'value' => true,
                'propertyValue' => '1.0',
                'expected' => true,
            ],
            'check string of float on false' => [
                'value' => false,
                'propertyValue' => '1.0',
                'expected' => false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsNumberEvaluator::doEvaluate
     *
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(bool $value, string $propertyValue, bool $expected): void
    {
        $evaluator = new ContainsNumberEvaluator($value);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
