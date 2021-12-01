<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter;

use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintResultTest extends TestCase
{
    public function providerForTestIsFail(): array
    {
        return [
            [
                LintResult::fail(new EmptyNote(), 0.12),
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsFail
     * @covers \ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote::getDescription
     */
    public function testIsFail(LintResult $result, bool $expected): void
    {
        self::assertEquals($expected, $result->isFail());
    }
}
