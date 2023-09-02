<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule\TitleConventionalRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule\TitleConventionalTask;
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
                'expectedNotes' => [
                    'The title must matches with conventional commit',
                ],
            ],
            'lint ok: title with no body' => [
                $this->makeMergeRequest([
                    'title' => 'docs: correct spelling of CHANGELOG',
                ]),
                [],
                'expectedNotes' => [],
            ],
            'link ok: commit message with scope' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [],
                'expectedNotes' => [],
            ],
            'lint failed: commit message with scope and unknown type' => [
                $this->makeMergeRequest([
                    'title' => 'unknown(lang): add Polish language',
                ]),
                [],
                'expectedNotes' => [
                    'Title conventional: type "unknown" is unknown',
                ],
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
                'expectedNotes' => [],
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
                'expectedNotes' => [
                    'Title conventional: type "unknown" is unknown',
                ],
            ],
            'lint ok: commit message has specified task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): ABC-123 add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(new Arrayee(['ABC'])),
                ],
                'expectedNotes' => [],
            ],
            'lint failed: commit message no has specified task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(new Arrayee([])),
                ],
                'expectedNotes' => [
                    'Description of title must starts with task number',
                ],
            ],
            'lint failed: commit message no has task number' => [
                $this->makeMergeRequest([
                    'title' => 'feat(lang): add Polish language',
                ]),
                [
                    'task' => new TitleConventionalTask(new Arrayee(['ABC'])),
                ],
                'expectedNotes' => [
                    'Description of title must starts with task number of projects ["ABC"]',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule\TitleConventionalRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule\TitleConventionalRule::checkTask
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectedNotes): void
    {
        $givenNotes = array_map('strval', TitleConventionalRule::make(...$ruleParams)->lint($request));

        self::assertSame(
            $expectedNotes,
            $givenNotes,
        );
    }
}
