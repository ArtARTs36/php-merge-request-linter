<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;

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
