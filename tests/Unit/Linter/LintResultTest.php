<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter;

use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintResultTest extends TestCase
{
    public function providerForTestIsFail(): array
    {
        return [
            [
                LintResult::fail(new EmptyNote(), new Duration(0.12)),
                true,
            ],
            [
                LintResult::successWithNote(new EmptyNote(), new Duration(0.13)),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsFail
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::isFail
     */
    public function testIsFail(LintResult $result, bool $expected): void
    {
        self::assertEquals($expected, $result->isFail());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::fail
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::__construct
     */
    public function testFail(): void
    {
        $result = LintResult::fail(new EmptyNote(), new Duration(0.12));

        self::assertFalse($result->state);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::successWithNote
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::__construct
     */
    public function testSuccess(): void
    {
        $result = LintResult::successWithNote(new EmptyNote(), new Duration(0.12));

        self::assertTrue($result->state);
    }
}
