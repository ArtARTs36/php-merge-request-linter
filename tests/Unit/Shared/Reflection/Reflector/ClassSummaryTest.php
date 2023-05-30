<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ClassSummary;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ClassSummaryTest extends TestCase
{
    public function providerForTestFindInPhpDocComment(): array
    {
        return [
            [
                '/**
 * Test summary.
 */',
                'Test summary.',
            ],
            [
                '/**
 * Test summary.
 * @copyright Name
 * @package Test
 */',
                'Test summary.',
            ],
            [
                '/**
 * @copyright Name
 * Test summary.
 * @package Test
 */',
                'Test summary.',
            ],
            [
                '',
                null,
            ],
            [
                '/**
 * Test summary.
 * Test summary2.
 * @copyright Name
 * @package Test
 */',
                'Test summary.',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ClassSummary::findInPhpDocComment
     * @dataProvider providerForTestFindInPhpDocComment
     */
    public function testFindInPhpDocComment(string $comment, ?string $expected): void
    {
        self::assertEquals($expected, ClassSummary::findInPhpDocComment($comment));
    }
}
