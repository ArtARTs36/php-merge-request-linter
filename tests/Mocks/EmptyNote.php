<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Note\AbstractNote;

final class EmptyNote extends AbstractNote
{
    public function getDescription(): string
    {
        return '';
    }
}
