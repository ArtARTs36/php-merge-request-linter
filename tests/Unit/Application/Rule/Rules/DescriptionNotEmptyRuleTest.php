<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DescriptionNotEmptyRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Test',
                ]),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionNotEmptyRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionNotEmptyRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionNotEmptyRule::getDefinition
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertHasNotes($request, new DescriptionNotEmptyRule(), $hasNotes);
    }
}
