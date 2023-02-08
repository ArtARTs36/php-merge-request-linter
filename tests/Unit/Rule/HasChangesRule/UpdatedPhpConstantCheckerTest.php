<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Request\Data\Change;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Diff;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Line;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Type;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;
use ArtARTs36\MergeRequestLinter\Rule\HasChangesRule\UpdatedPhpConstantChecker;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class UpdatedPhpConstantCheckerTest extends TestCase
{
    public function providerForTestCheck(): array
    {
        return [
            [
                [
                    'const KKK=1',
                ],
                'KKK',
                false,
            ],
            [
                [
                    'const KKKA=1',
                ],
                'KKK',
                true,
            ],
            [
                [
                    'const KKK   =1',
                ],
                'KKK',
                false,
            ],
            [
                [
                    'const     KKK   =1',
                ],
                'KKK',
                false,
            ],
            [
                [
                    "define('KKK', 1)",
                ],
                'KKK',
                false,
            ],
            [
                [
                    'define("KKK", 1)',
                ],
                'KKK',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasChangesRule\UpdatedPhpConstantChecker::check
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasChangesRule\UpdatedPhpConstantChecker::__construct
     * @dataProvider providerForTestCheck
     * @param array<string> $lines
     */
    public function testCheck(array $lines, string $constant, bool $hasNotes): void
    {
        $needChange = new FileChange('', null, null, $constant);
        $requestChange = new Change('', new Diff(array_map(function (string $line) {
            return new Line(Type::NEW, Str::make($line));
        }, $lines)));

        $checker = new UpdatedPhpConstantChecker();

        self::assertEquals($hasNotes, count($checker->check($needChange, $requestChange)) > 0);
    }
}
