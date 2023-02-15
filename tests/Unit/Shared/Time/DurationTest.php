<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DurationTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Duration::__toString
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Duration::__construct
     */
    public function testToString(): void
    {
        $duration = new Duration(0.12);

        self::assertEquals('0.12s', (string) $duration);
    }
}
