<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\StaticEvaluatingSubject;

class AnyEvaluator extends IterEvaluator
{
    public const NAME = '$any';

    public function evaluate(EvaluatingSubject $subject): bool
    {
        foreach ($subject->collection() as $index => $value) {
            $name = sprintf('%s[%s]', $subject->name(), (string) $index);

            foreach ($this->value as $evaluator) {
                if ($evaluator->evaluate(new StaticEvaluatingSubject($name, $value))) {
                    return true;
                }
            }
        }

        return false;
    }
}
