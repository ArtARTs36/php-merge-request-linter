<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;

final class MockConditionOperator implements ConditionOperator
{
    public function __construct(
        private bool $value,
    ) {
        //
    }

    public static function true(): self
    {
        return new self(true);
    }

    public static function false(): self
    {
        return new self(false);
    }

    public function check(object $subject): bool
    {
        return $this->value;
    }
}
