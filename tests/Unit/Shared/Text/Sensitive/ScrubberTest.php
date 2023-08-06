<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Text\Sensitive;

use ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive\Scrubber;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ScrubberTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive\Scrubber::scrub
     */
    public function testScrub(): void
    {
        self::assertEquals(
            't**t',
            Scrubber::scrub('test'),
        );
    }
}
