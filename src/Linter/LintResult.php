<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Note\Notes;

class LintResult
{
    public function __construct(
        public bool $state,
        public Notes $errors,
        public float $duration,
    ) {
        //
    }

    public static function good(Note $note, float $duration): self
    {
        return new self(true, new Notes([$note]), $duration);
    }

    public static function bad(Note $note, float $duration): self
    {
        return new self(false, new Notes([$note]), $duration);
    }

    public function isFail(): bool
    {
        return ! $this->state;
    }
}
