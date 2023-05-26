<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;

class LintResult
{
    /**
     * @param Arrayee<int, Note> $notes
     */
    public function __construct(
        public LintState $state,
        #[Generic(Note::class)]
        public Arrayee $notes,
        public Duration $duration,
    ) {
        //
    }

    public static function successWithNote(Note $note, Duration $duration): self
    {
        return new self(LintState::Success, new Arrayee([$note]), $duration);
    }

    public static function fail(Note $note, Duration $duration): self
    {
        return new self(LintState::Fail, new Arrayee([$note]), $duration);
    }
}
