<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Note;

use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ExceptionNoteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Note\ExceptionNote::withMessage
     */
    public function testWithMessageOnMessageEmpty(): void
    {
        self::expectException(\InvalidArgumentException::class);

        ExceptionNote::withMessage(new \LogicException(), '');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Note\ExceptionNote::withMessage
     */
    public function testWithMessage(): void
    {
        $note = ExceptionNote::withMessage(new \LogicException(), 'Test');

        self::assertEquals('Test :: LogicException', $note->getDescription());
    }
}
