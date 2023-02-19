<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;

final class Chain implements EvaluatorCreator
{
    /**
     * @param array<EvaluatorCreator> $creators
     */
    public function __construct(
        private array $creators = [],
    ) {
        //
    }

    public function add(EvaluatorCreator $creator): self
    {
        $this->creators[] = $creator;

        return $this;
    }

    public function create(string $type, mixed $value): ?ConditionEvaluator
    {
        foreach ($this->creators as $creator) {
            $evaluator = $creator->create($type, $value);

            if ($evaluator !== null) {
                return $evaluator;
            }
        }

        return null;
    }
}
