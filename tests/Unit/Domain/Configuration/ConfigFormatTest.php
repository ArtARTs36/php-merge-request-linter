<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConfigFormatTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat::list
     */
    public function testList(): void
    {
        $list = ConfigFormat::list();

        $isArrayOfString = true;

        foreach ($list as $value) {
            if (! is_string($value)) {
                $isArrayOfString = false;
            }
        }

        self::assertTrue($isArrayOfString);
    }
}
