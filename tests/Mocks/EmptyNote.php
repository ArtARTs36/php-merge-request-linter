<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Note\AbstractNote;
use ArtARTs36\MergeRequestLinter\Note\NoteColor;

final class EmptyNote extends AbstractNote
{
    public function getColor(): NoteColor
    {
        return NoteColor::WHITE;
    }

    public function getDescription(): string
    {
        return '';
    }
}
