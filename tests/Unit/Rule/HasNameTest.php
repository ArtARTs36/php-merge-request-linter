<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Rule\HasName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class HasNameTest extends TestCase
{
    public function testGetName(): void
    {
        $rule = new TestRule();

        self::assertEquals('test', $rule->getName());
    }
}

class TestRule
{
    use HasName;
}
