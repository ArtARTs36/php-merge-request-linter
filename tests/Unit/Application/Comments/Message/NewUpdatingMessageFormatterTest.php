<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\NewUpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NewUpdatingMessageFormatterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\NewUpdatingMessageFormatter::formatMessage
     */
    public function testFormatMessage(): void
    {
        $formatter = new NewUpdatingMessageFormatter();

        self::assertEquals(
            'test-message',
            $formatter->formatMessage('123', 'test-message'),
        );
    }
}
