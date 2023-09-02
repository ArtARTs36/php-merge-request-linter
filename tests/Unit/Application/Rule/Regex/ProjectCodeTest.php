<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Regex;

use ArtARTs36\MergeRequestLinter\Application\Rule\Regex\ProjectCode;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ProjectCodeTest extends TestCase
{
    public static function providerForFindInStart(): array
    {
        return [
            [
                'string' => 'title abc 123',
                'expectedProjectCode' => null,
            ],
            [
                'string' => 'ABC- title abc 123',
                'expectedProjectCode' => null,
            ],
            [
                'string' => 'ABC-123 title abc 123',
                'expectedProjectCode' => 'ABC',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Regex\ProjectCode::findInStart
     *
     * @dataProvider providerForFindInStart
     */
    public function testFindInStart(string $string, ?string $expectedProjectCode): void
    {
        self::assertEquals(
            $expectedProjectCode,
            ProjectCode::findInStart(Str::make($string)),
        );
    }
}
