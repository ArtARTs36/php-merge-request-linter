<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

/**
 * @phpstan-type EvaluatorName string
 */
class EvaluatorFactory
{
    /**
     * @param Map<EvaluatorName, class-string<ConditionEvaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly Map $evaluatorByType,
        private readonly EvaluatingSubjectFactory $subjectFactory,
    ) {
        //
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, mixed $value): ConditionEvaluator
    {
        if ($type === AllEvaluator::NAME && is_array($value)) {
            return $this->createAllEvaluator($value);
        } elseif ($type === AnyEvaluator::NAME && is_array($value)) {
            return $this->createAnyEvaluator($value);
        } elseif (str_contains($type, ContainsHeadingEvaluator::PREFIX_NAME)) {
            return $this->createContainsHeadingEvaluator($type, $value);
        }

        return $this->createByType($type, $value);
    }

    private function createContainsHeadingEvaluator(string $type, mixed $value): ContainsHeadingEvaluator
    {
        [, $level] = explode(ContainsHeadingEvaluator::PREFIX_NAME, $type, 2);

        return new ContainsHeadingEvaluator(
            $value,
            $level,
        );
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    private function createByType(string $type, mixed $value): ConditionEvaluator
    {
        $class = $this->evaluatorByType->get($type);

        if ($class === null) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return new $class($value);
    }

    /**
     * @param array<EvaluatorName, mixed> $value
     */
    private function createAllEvaluator(array $value): ConditionEvaluator
    {
        $evaluators = [];

        foreach ($value as $evName => $val) {
            $evaluators[] = $this->create($evName, $val);
        }

        return new AllEvaluator($evaluators, $this->subjectFactory);
    }

    /**
     * @param array<EvaluatorName, mixed> $value
     */
    private function createAnyEvaluator(array $value): ConditionEvaluator
    {
        $evaluators = [];

        foreach ($value as $evName => $val) {
            $evaluators[] = $this->create($evName, $val);
        }

        return new AnyEvaluator($evaluators, $this->subjectFactory);
    }
}
