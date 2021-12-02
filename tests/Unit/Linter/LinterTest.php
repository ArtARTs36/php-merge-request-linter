<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Linter;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\StopsLint;
use ArtARTs36\MergeRequestLinter\Rule\Definition;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Linter\Linter::run
     */
    public function testRunOnStopException(): void
    {
        $linter = new Linter(Rules::make([
            new class () implements Rule {
                use StopsLint;

                public function lint(MergeRequest $request): array
                {
                    $this->stop('Test-stop');
                }

                public function getDefinition(): RuleDefinition
                {
                    return new Definition('');
                }
            },
        ]));

        self::assertEquals('Lint stopped. Reason: Test-stop', $linter->run($this->makeMergeRequest())->first());
    }
}
