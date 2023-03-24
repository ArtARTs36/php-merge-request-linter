<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\InvalidEvaluatorValueException;

final class ContainsHeadingEvaluatorCreator implements EvaluatorCreator
{
    public function create(string $type, mixed $value): ?ConditionEvaluator
    {
        if (! str_contains($type, ContainsHeadingEvaluator::PREFIX_NAME)) {
            return null;
        }

        if (! is_string($value)) {
            throw new InvalidEvaluatorValueException(sprintf(
                'Value for evaluator "%s" must be string. ',
                ContainsHeadingEvaluator::PREFIX_NAME,
            ));
        }

        $level = $this->extractHeadingLevel($type);

        return new ContainsHeadingEvaluator(
            $value,
            $level,
        );
    }

    private function extractHeadingLevel(string $type): int
    {
        $parts = explode(ContainsHeadingEvaluator::PREFIX_NAME, $type, 2);

        if (! isset($parts[1]) || ! is_numeric($parts[1])) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return (int) $parts[1];
    }
}
