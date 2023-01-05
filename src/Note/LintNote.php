<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;

final class LintNote extends AbstractNote implements Note
{
    public function __construct(
        protected string $description,
    ) {
        //
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
