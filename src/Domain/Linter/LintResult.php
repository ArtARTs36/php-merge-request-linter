<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\Notes;

class LintResult
{
    public function __construct(
        public bool $state,
        #[Generic(Note::class)]
        public Notes $notes,
        public Duration $duration,
    ) {
        //
    }

    public static function successWithNote(Note $note, Duration $duration): self
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
