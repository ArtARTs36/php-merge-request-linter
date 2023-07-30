<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;

class MessageSelector
{
    public function __construct(
        private readonly OperatorResolver $condition,
    ) {
        //
    }

    public function select(CommentsConfig $config, LintResult $result): ?CommentsMessage
    {
        $conditionObject = new MessageConditions(
            $result,
        );

        foreach ($config->messages as $message) {
            if (count($message->conditions) === 0) {
                return $message;
            }

            if ($this->condition->resolve($message->conditions)->check($conditionObject)) {
                return $message;
            }
        }

        return null;
    }
}
