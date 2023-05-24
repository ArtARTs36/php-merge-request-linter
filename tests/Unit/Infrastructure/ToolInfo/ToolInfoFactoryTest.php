<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ToolInfoFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory::create
     */
    public function testCreate(): void
    {
        $factory = new ToolInfoFactory(LocalClock::utc());

        self::assertInstanceOf(ToolInfo::class, $factory->create());
    }
}
