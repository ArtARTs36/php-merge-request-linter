<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Note;

use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote::withSeverity
     */
    public function testWithSeverity(): void
    {
        $note = new ExceptionNote(new \Exception(''));

        self::assertEquals(
            NoteSeverity::Warning,
            $note->withSeverity(NoteSeverity::Warning)->getSeverity(),
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote::jsonSerialize
     */
    public function testJsonSerialize(): void
    {
        $note = new ExceptionNote($e = new \Exception('exception msg'));

        self::assertEquals(
            [
                'description' => sprintf(
                    'exception msg (exception Exception on %s#%s)',
                    $e->getFile(),
                    $e->getLine(),
                ),
                'severity' => NoteSeverity::Fatal->value,
            ],
            $note->jsonSerialize(),
        );
    }
}
