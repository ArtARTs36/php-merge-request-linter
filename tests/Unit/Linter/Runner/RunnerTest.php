<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     */
    public function testRunOnCiNotDetected(): void
    {
        $runner = new Runner(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new CiNotSupported();
            }
        });

        $result = $runner->run(new Linter(new Rules([])));

        self::assertEquals(false, $result->state);
        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     */
    public function testRunOnNotMergeRequest(): void
    {
        $runner = new Runner(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                return new MockCi([
                    'is_pull_request' => false,
                ]);
            }
        });

        $result = $runner->run(new Linter(new Rules([])));

        self::assertTrue($result->state);
        self::assertEquals('Currently is not merge request', $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     */
    public function testRunOnInvalidCredentials(): void
    {
        $runner = new Runner(new class implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new InvalidCredentialsException();
            }
        });

        $result = $runner->run((new Linter((new Rules([])))));

        self::assertFalse($result->state);
        self::assertEquals(
            'Invalid credentials :: ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException',
            $result->notes->first()->getDescription()
        );
    }
}
