<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @phpstan-type Field string
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 * @phpstan-type Conditions array<Field, Condition>
 * @codeCoverageIgnore
 */
readonly class CommentsMessage
{
    /**
     * @param Conditions $conditions
     */
    public function __construct(
        public string $template,
        public array  $conditions,
    ) {
    }
}
