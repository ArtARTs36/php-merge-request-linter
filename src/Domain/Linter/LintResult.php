<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;

class LintResult
{
    public function __construct(
        public bool $state,
        #[Generic(Note::class)]
        public Arrayee $notes,
        public Duration $duration,
    ) {
        //
    }

    public static function successWithNote(Note $note, Duration $duration): self
    {
        return new self(true, new Arrayee([$note]), $duration);
    }

    public static function fail(Note $note, Duration $duration): self
    {
        return new self(false, new Arrayee([$note]), $duration);
    }

    public function isFail(): bool
    {
        return ! $this->state;
    }
}
