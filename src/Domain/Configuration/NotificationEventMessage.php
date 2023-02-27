<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;

/**
 * @phpstan-type Field string
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 * @codeCoverageIgnore
 */
class NotificationEventMessage
{
    /**
     * @param array<Field, ConditionValue> $conditions
     */
    public function __construct(
        public readonly string $event,
        public readonly Channel $channel,
        public readonly string $template,
        public readonly array $conditions = [],
    ) {
        //
    }
}
