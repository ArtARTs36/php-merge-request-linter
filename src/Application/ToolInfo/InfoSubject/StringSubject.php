<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

final class StringSubject implements InfoSubject
{
    public function __construct(
        private readonly string $theme,
        private readonly string $value,
    ) {
    }

    public function describe(): string
    {
        return sprintf('%s: %s', $this->theme, $this->value);
    }
}
