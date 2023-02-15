<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * True if any value of array matched conditions.
 */
class AnyEvaluator extends CompositeEvaluator
{
    public const NAME = '$any';

    public function evaluate(EvaluatingSubject $subject): bool
    {
        foreach ($subject->collection() as $index => $value) {
            $name = sprintf('%s[%s]', $subject->name(), (string) $index);

            foreach ($this->value as $evaluator) {
                if ($evaluator->evaluate($this->subjectFactory->createForValue($name, $value))) {
                    return true;
                }
            }
        }

        return false;
    }
}
