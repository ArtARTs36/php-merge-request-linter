<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;

/**
 * @phpstan-type Field string
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 * @phpstan-type Conditions array<Field, Condition>
 * @codeCoverageIgnore
 */
readonly class NotificationEventMessage
{
    /**
     * @param Conditions $conditions
     */
    public function __construct(
        public string  $event,
        public Channel $channel,
        public string  $template,
        public array   $conditions = [],
    ) {
    }
}
