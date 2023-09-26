<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

final readonly class StringSubject implements InfoSubject
{
    public function __construct(
        private string $theme,
        private string $value,
    ) {
    }

    public function describe(): string
    {
        return sprintf('%s: %s', $this->theme, $this->value);
    }
}
