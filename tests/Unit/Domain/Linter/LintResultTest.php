<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintResultTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::successWithNote
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::__construct
     */
    public function testSuccess(): void
    {
        $result = LintResult::successWithNote(new EmptyNote(), new Duration(0.12));

        self::assertEquals(LintState::Success, $result->state);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult::fail
     */
    public function testFail(): void
    {
        $result = LintResult::fail(new EmptyNote(), new Duration(1));

        self::assertEquals(LintState::Fail, $result->state);
    }
}
