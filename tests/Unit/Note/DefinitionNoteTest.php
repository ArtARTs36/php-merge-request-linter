<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Note;

use ArtARTs36\MergeRequestLinter\Note\DefinitionNote;
use ArtARTs36\MergeRequestLinter\Rule\Definition;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DefinitionNoteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Note\DefinitionNote::__toString
     * @covers \ArtARTs36\MergeRequestLinter\Note\DefinitionNote::getDescription
     * @covers \ArtARTs36\MergeRequestLinter\Note\DefinitionNote::__construct
     */
    public function testGetDescription(): void
    {
        self::assertEquals('desc', new DefinitionNote(new Definition('desc')));
    }
}
