<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

interface TextRenderer
{
    public function render(string $text, Map $data): string;
}
