<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

final class BoolSubject implements InfoSubject
{
    public function __construct(
        private readonly string $theme,
        private readonly bool $value,
    ) {
        //
    }

    public function describe(): string
    {
        return sprintf('%s: %s', $this->theme, $this->value ? 'true' : 'false');
    }
}
