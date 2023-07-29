<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DisableFileExtensionsRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DisableFileExtensionsRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                'disabledExtensions' => [],
                'changes' => [],
                'expectedNotes' => [],
            ],
            [
                'disabledExtensions' => [],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                ],
                'expectedNotes' => [],
            ],
            [
                'disabledExtensions' => ['jpg'],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                ],
                'expectedNotes' => [],
            ],
            [
                'disabledExtensions' => ['txt'],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                ],
                'expectedNotes' => [
                    'File "1.txt" has disabled extension "txt"',
                ],
            ],
            [
                'disabledExtensions' => ['txt'],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                    '2.txt' => new Change('2.txt', Diff::empty()),
                ],
                'expectedNotes' => [
                    'File "1.txt" has disabled extension "txt"',
                    'File "2.txt" has disabled extension "txt"',
                ],
            ],
            [
                'disabledExtensions' => ['txt', 'jpg'],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                    '2.txt' => new Change('2.txt', Diff::empty()),
                ],
                'expectedNotes' => [
                    'File "1.txt" has disabled extension "txt"',
                    'File "2.txt" has disabled extension "txt"',
                ],
            ],
            [
                'disabledExtensions' => ['txt', 'jpg'],
                'changes' => [
                    '1.txt' => new Change('1.txt', Diff::empty()),
                    '2.txt' => new Change('2.txt', Diff::empty()),
                    '3.jpg' => new Change('3.jpg', Diff::empty()),
                ],
                'expectedNotes' => [
                    'File "1.txt" has disabled extension "txt"',
                    'File "2.txt" has disabled extension "txt"',
                    'File "3.jpg" has disabled extension "jpg"',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DisableFileExtensionsRule::lint
     * @dataProvider providerForTestLint
     *
     * @param array<string> $disabledExtensions
     * @param array<string, Change> $changes
     * @param array<string> $expectedNotes
     */
    public function testLint(array $disabledExtensions, array $changes, array $expectedNotes): void
    {
        $rule = new DisableFileExtensionsRule(Set::fromList($disabledExtensions));

        $request = $this->makeMergeRequest([
            'changes' => $changes,
        ]);

        self::assertEquals($expectedNotes, array_map('strval', $rule->lint($request)));
    }
}
