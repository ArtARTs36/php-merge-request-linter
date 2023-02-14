<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\NeedFileChange;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\UpdatedPhpConstantChecker;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\UpdatedPhpConstantChecker::check
     * @dataProvider providerForTestCheck
     * @param array<string> $lines
     */
    public function testCheck(array $lines, string $constant, bool $hasNotes): void
    {
        $needChange = new NeedFileChange('', null, null, $constant);
        $requestChange = new Change('', new Diff(array_map(function (string $line) {
            return new DiffLine(DiffType::NEW, Str::make($line));
        }, $lines)));

        $checker = new UpdatedPhpConstantChecker();

        self::assertEquals($hasNotes, count($checker->check($needChange, $requestChange)) > 0);
    }
}
