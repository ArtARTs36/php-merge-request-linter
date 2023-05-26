<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
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

        $result = $runner->run($this->createLinter());

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

        $result = $runner->run($this->createLinter());

        self::assertEquals(LintState::Success, $result->state);
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

        $result = $runner->run($this->createLinter());

        self::assertFalse($result->state);
        self::assertEquals(
            'Exception ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException',
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

        $result = $runner->run($this->createLinter([
            new SuccessRule(),
        ]));

        self::assertEquals(LintState::Success, $result->state);
    }

    private function createLinter(array $rules = []): Linter
    {
        return new Linter(
            Rules::make($rules),
            new LinterOptions(false),
            new NullEventDispatcher(),
            new NullMetricManager(),
        );
    }
}
