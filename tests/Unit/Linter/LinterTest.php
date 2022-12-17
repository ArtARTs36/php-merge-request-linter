<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Linter\Event\NullLintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\StopsLint;
use ArtARTs36\MergeRequestLinter\Rule\Definition;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Linter::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Linter::__construct
     */
    public function testRunOnStopException(): void
    {
        $linter = new Linter(Rules::make([
            new class () implements Rule {
                use StopsLint;

                public function getName(): string
                {
                    return 'anonymous_rule';
                }

                public function lint(MergeRequest $request): array
                {
                    $this->stop('Test-stop');
                }

                public function getDefinition(): RuleDefinition
                {
                    return new Definition('');
                }
            },
        ]), new NullLintEventSubscriber());

        self::assertEquals('Lint stopped. Reason: Test-stop', $linter->run($this->makeMergeRequest())->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Linter::run
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Linter::__construct
     */
    public function testRunOnException(): void
    {
        $linter = new Linter(new Rules([
            new class () implements Rule {
                public function getName(): string
                {
                    return 'anonymous_rule';
                }

                public function lint(MergeRequest $request): array
                {
                    throw new \RuntimeException();
                }

                public function getDefinition(): RuleDefinition
                {
                    return new Definition('');
                }
            },
        ]), new NullLintEventSubscriber());

        $notes = $linter->run($this->makeMergeRequest());

        self::assertInstanceOf(ExceptionNote::class, $notes->first());
    }
}
