<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use ArtARTs36\MergeRequestLinter\Support\Time\Duration;

class LintResult
{
    public function __construct(
        public bool $state,
        public Notes $notes,
        public Duration $duration,
    ) {
        //
    }

    public static function success(Note $note, Duration $duration): self
    {
        return new self(true, new Notes([$note]), $duration);
    }

    public static function fail(Note $note, Duration $duration): self
    {
        return new self(false, new Notes([$note]), $duration);
    }

    public function isFail(): bool
    {
        return ! $this->state;
    }
}
