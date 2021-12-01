<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Note\Notes;

class LintResult
{
    public const STATE_CI_NOT_DETECTED = 0;
    public const STATE_OK = 1;
    public const STATE_ERRORS = 2;
    public const STATE_CURRENT_NOT_MERGE_REQUEST = 4;
    public const STATE_CI_NOT_SUPPORTED = 5;
    public const STATE_INVALID_CREDENTIALS = 6;

    public function __construct(
        public int $state,
        public Notes $errors,
        public float $duration,
    ) {
        //
    }

    public static function withoutErrors(int $state, float $duration): self
    {
        return new self($state, new Notes([]), $duration);
    }

    public function getState(): string
    {
        return [
            self::STATE_CI_NOT_DETECTED => 'CI not detected',
            self::STATE_OK => 'OK',
            self::STATE_ERRORS => 'Errors',
            self::STATE_CURRENT_NOT_MERGE_REQUEST => 'Currently is not merge request',
            self::STATE_CI_NOT_SUPPORTED => 'CI not supported',
            self::STATE_INVALID_CREDENTIALS => 'Credentials is invalid',
        ][$this->state];
    }

    public function isFail(): bool
    {
        return $this->state === self::STATE_ERRORS;
    }
}
