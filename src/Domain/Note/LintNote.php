<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

final class LintNote extends AbstractNote implements Note
{
    public function __construct(
        private readonly string $description,
    ) {
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function withSeverity(NoteSeverity $severity): Note
    {
        $note = new LintNote(
            $this->description,
        );

        $note->severity = $severity;

        return $note;
    }
}
