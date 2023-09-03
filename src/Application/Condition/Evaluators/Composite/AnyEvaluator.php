<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

#[Description('True if any value of array matched conditions.')]
final class AnyEvaluator extends CompositeEvaluator
{
    public const NAME = '$any';

    public function evaluate(EvaluatingSubject $subject): bool
    {
        foreach ($subject->interface(Collection::class) as $index => $value) {
            $name = sprintf('%s[%s]', $subject->name(), '' . $index);

            foreach ($this->value as $evaluator) {
                if ($evaluator->evaluate($this->subjectFactory->createForValue($name, $value))) {
                    return true;
                }
            }
        }

        return false;
    }
}
