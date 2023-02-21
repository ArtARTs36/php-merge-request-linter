<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\GraphQL\Tag;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TagTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag::digit
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag::__construct
     */
    public function testDigit(): void
    {
        $tag = new Tag('version', 1, 2, 3);

        self::assertEquals('1.2.3', $tag->digit());
    }
}
