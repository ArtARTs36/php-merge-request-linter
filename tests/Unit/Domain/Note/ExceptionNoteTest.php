<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Note;

use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ExceptionNoteTest extends TestCase
{
    public function providerForTestGetDescription(): array
    {
        return [
            'exception with message' => [
                'exception' => new \Exception('test-message'),
                'expected' => 'test-message (exception Exception on ' . __FILE__ . '#' . __LINE__ - 1 . ')',
            ],
            'exception without message' => [
                'exception' => new \Exception(),
                'expected' => 'Exception Exception',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote::getDescription
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote::__toString
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote::__construct
     * @dataProvider providerForTestGetDescription
     */
    public function testGetDescription(\Exception $exception, string $expected): void
    {
        $note = new ExceptionNote($exception);

        self::assertEquals($expected, $note->__toString());
    }
}
