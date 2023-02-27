<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::run
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\Linter::__construct
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
        ]), new NullEventDispatcher(), new NullMetricManager());

        $result = $linter->run($this->makeMergeRequest());

        self::assertInstanceOf(ExceptionNote::class, $result->notes->first());
    }
}
