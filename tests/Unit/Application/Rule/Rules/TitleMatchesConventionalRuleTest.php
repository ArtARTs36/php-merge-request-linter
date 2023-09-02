<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalTask;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

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
            'lint ok: commit message has specified task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): ABC-123 add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(['ABC']),
                ],
                false,
            ],
            'lint failed: commit message no has specified task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(['ABC']),
                ],
                true,
            ],
            'lint failed: commit message no has task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(['ABC']),
                ],
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule::lint
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        var_dump(TitleConventionalRule::make(...$ruleParams)->lint($request));

        self::assertHasNotes($request, TitleConventionalRule::make(...$ruleParams), $hasNotes);
    }
}
