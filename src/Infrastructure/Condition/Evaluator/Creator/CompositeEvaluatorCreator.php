<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\CompositeEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

final class CompositeEvaluatorCreator implements EvaluatorCreator
{
    /**
     * @param class-string<CompositeEvaluator> $compositeEvaluatorClass
     */
    public function __construct(
        protected readonly EvaluatingSubjectFactory $subjectFactory,
        protected readonly EvaluatorCreator $chain,
        protected readonly string $compositeEvaluatorClass,
    ) {
    }

    public function create(string $type, mixed $value): ?ConditionEvaluator
    {
        if ($type !== $this->compositeEvaluatorClass::NAME || ! is_array($value) || count($value) === 0) {
            return null;
        }

        $evaluators = [];

        foreach ($value as $evaluatorName => $val) {
            $subResolver = $this->chain->create($evaluatorName, $val);

            if ($subResolver === null) {
                throw ConditionEvaluatorNotFound::make($evaluatorName);
            }

            $evaluators[] = $subResolver;
        }

        return new ($this->compositeEvaluatorClass)($evaluators, $this->subjectFactory);
    }
}
