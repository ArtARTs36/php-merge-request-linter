<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

class NullRenderer implements TextRenderer
{
    public function render(string $text, array $data): string
    {
        return $text;
    }
}
