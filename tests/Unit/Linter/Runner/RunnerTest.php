<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyMergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCIDetector;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     */
    public function testRunOnCiNotDetected(): void
    {
        $runner = new Runner(MockCIDetector::null(), new EmptyMergeRequestFetcher());
        $result = $runner->run(new Linter(new Rules([])));

        self::assertEquals(false, $result->state);
        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }
}
