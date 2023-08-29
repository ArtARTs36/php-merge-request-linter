<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleMatchesConventionalRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            'lint failed: invalid title' => [
                $this->makeMergeRequest([
                    'title' => 'Test',
                ]),
                [],
                true,
            ],
            'lint ok: title with no body' => [
                $this->makeMergeRequest([
                    'title' => 'docs: correct spelling of CHANGELOG',
                ]),
                [],
                false,
            ],
            'link ok: commit message with scope' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [],
                false,
            ],
            'lint failed: commit message with scope and unknown type' => [
                $this->makeMergeRequest([
                    'title' => 'unknown(lang): add Polish language',
                ]),
                [],
                true,
            ],
            'lint ok: commit message with scope and custom type' => [
                $this->makeMergeRequest([
                    'title' => 'custom(lang): add Polish language',
                ]),
                [
                    'types' => new Arrayee([
                        'custom',
                    ]),
                ],
                false,
            ],
            'lint failed: commit message with scope, custom types, unknown type' => [
                $this->makeMergeRequest([
                    'title' => 'unknown(lang): add Polish language',
                ]),
                [
                    'types' => new Arrayee([
                        'custom',
                    ]),
                ],
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule::doLint
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        self::assertHasNotes($request, TitleConventionalRule::make(...$ruleParams), $hasNotes);
    }
}
