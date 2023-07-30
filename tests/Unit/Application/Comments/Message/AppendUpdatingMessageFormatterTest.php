<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\AppendUpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AppendUpdatingMessageFormatterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\AppendUpdatingMessageFormatter::formatMessage
     */
    public function testFormatMessage(): void
    {
        $formatter = new AppendUpdatingMessageFormatter();

        self::assertEquals(
            "1\n---\n2",
            $formatter->formatMessage('1', '2'),
        );
    }
}
