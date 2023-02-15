<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

final class LintNote extends AbstractNote implements Note
{
    public function __construct(
        private readonly string $description,
    ) {
        //
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
