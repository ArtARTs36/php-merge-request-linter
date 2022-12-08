<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullLintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::__construct
     */
    public function testRunOnCiNotDetected(): void
    {
        $runner = new Runner(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new CiNotSupported();
            }
        });

        $result = $runner->run(new Linter(new Rules([]), new NullLintEventSubscriber()));

        self::assertEquals(false, $result->state);
        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::__construct
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

        $result = $runner->run(new Linter(new Rules([]), new NullLintEventSubscriber()));

        self::assertTrue($result->state);
        self::assertEquals('Currently is not merge request', $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::__construct
     */
    public function testRunOnInvalidCredentials(): void
    {
        $runner = new Runner(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new InvalidCredentialsException();
            }
        });

        $result = $runner->run((new Linter(new Rules([]), new NullLintEventSubscriber())));

        self::assertFalse($result->state);
        self::assertEquals(
            'Invalid credentials :: ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException',
            $result->notes->first()->getDescription()
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Runner\Runner::__construct
     */
    public function testRunSuccess(): void
    {
        $runner = new Runner(new class ($this->makeMergeRequest()) implements CiSystemFactory {
            public function __construct(private MergeRequest $request)
            {
                //
            }

            public function createCurrently(): CiSystem
            {
                return new MockCi(['is_pull_request' => true], $this->request);
            }
        });

        $result = $runner->run(new Linter(Rules::make([
            new SuccessRule(),
        ]), new NullLintEventSubscriber()));

        self::assertTrue($result->state);
    }
}
