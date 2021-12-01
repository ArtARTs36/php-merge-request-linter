<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

class LintResult
{
    public const STATE_CI_NOT_DETECTED = 0;
    public const STATE_OK = 1;
    public const STATE_ERRORS = 2;
    public const STATE_CURRENT_NOT_MERGE_REQUEST = 4;

    public function __construct(
        public int $state,
        public LintErrors $errors,
        public float $duration,
    ) {
        //
    }

    public static function withoutErrors(int $state, float $duration): self
    {
        return new self($state, new LintErrors([]), $duration);
    }

    public function getState(): string
    {
        return [
            self::STATE_CI_NOT_DETECTED => 'CI Not Detected',
            self::STATE_OK => 'OK',
            self::STATE_ERRORS => 'Errors',
            self::STATE_CURRENT_NOT_MERGE_REQUEST => 'Currently is not merge request',
        ][$this->state];
    }

    public function isFail(): bool
    {
        return $this->state === self::STATE_ERRORS;
    }
}
