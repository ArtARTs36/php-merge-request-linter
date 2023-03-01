<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EvaluatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator::evaluate
     */
    public function testLintOnPropertyHasDifferentTypeException(): void
    {
        $evaluator = new class () extends Evaluator {
            protected function doEvaluate(EvaluatingSubject $subject): bool
            {
                throw new PropertyHasDifferentTypeException('prop', 'string', 'int');
            }
        };

        self::expectException(ComparedIncompatibilityTypesException::class);

        $evaluator->evaluate(new MockEvaluatingSubject(''));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator::evaluate
     */
    public function testLintOnPropertyNotExists(): void
    {
        $evaluator = new class () extends Evaluator {
            public const NAME = 'test';

            protected function doEvaluate(EvaluatingSubject $subject): bool
            {
                throw new PropertyNotExists('prop', 'string');
            }
        };

        self::expectExceptionMessage('Operator "test": property request.string not exists');

        $evaluator->evaluate(new MockEvaluatingSubject(''));
    }
}
