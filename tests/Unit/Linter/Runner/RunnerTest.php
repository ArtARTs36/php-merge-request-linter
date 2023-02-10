<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RunnerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::__construct
     */
    public function testRunOnCiNotDetected(): void
    {
        $runner = new Runner(new CiRequestFetcher(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new CiNotSupported();
            }
        }, new NullMetricManager()));

        $result = $runner->run(new Linter(new Rules([]), new NullEventDispatcher()));

        self::assertEquals(false, $result->state);
        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::__construct
     */
    public function testRunOnNotMergeRequest(): void
    {
        $runner = new Runner(new CiRequestFetcher(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                return new MockCi([
                    'is_pull_request' => false,
                ]);
            }
        }, new NullMetricManager()));

        $result = $runner->run(new Linter(new Rules([]), new NullEventDispatcher()));

        self::assertTrue($result->state);
        self::assertEquals('Currently is not merge request', $result->notes->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::__construct
     */
    public function testRunOnInvalidCredentials(): void
    {
        $runner = new Runner(new CiRequestFetcher(new class () implements CiSystemFactory {
            public function createCurrently(): CiSystem
            {
                throw new InvalidCredentialsException();
            }
        }, new NullMetricManager()));

        $result = $runner->run((new Linter(new Rules([]), new NullEventDispatcher())));

        self::assertFalse($result->state);
        self::assertEquals(
            'Exception ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException',
            $result->notes->first()->getDescription()
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Runner::__construct
     */
    public function testRunSuccess(): void
    {
        $runner = new Runner(new CiRequestFetcher(new class ($this->makeMergeRequest()) implements CiSystemFactory {
            public function __construct(private MergeRequest $request)
            {
                //
            }

            public function createCurrently(): CiSystem
            {
                return new MockCi(['is_pull_request' => true], $this->request);
            }
        }, new NullMetricManager()));

        $result = $runner->run(new Linter(Rules::make([
            new SuccessRule(),
        ]), new NullEventDispatcher()));

        self::assertTrue($result->state);
    }
}
