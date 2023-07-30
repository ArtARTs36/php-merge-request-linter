<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;

final class MockTextRenderer implements TextRenderer
{
    public function __construct(
        private readonly string $rendered,
    ) {
    }

    public function render(string $text, array $data): string
    {
        return $this->rendered;
    }
}
