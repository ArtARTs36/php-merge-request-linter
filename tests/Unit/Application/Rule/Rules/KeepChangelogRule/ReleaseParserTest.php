<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules\KeepChangelogRule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\Release;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseChanges;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseParser;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ReleaseParserTest extends TestCase
{
    public static function providerForTestParse(): array
    {
        return [
            [
                'str' => <<<HTML
## v1.0.0 super release

### Added
* item 1
* item 2

Other text
HTML,
                'expected' => [
                    new Release(
                        'v1.0.0 super release',
                        'v1.0.0',
                        [
                            new ReleaseChanges('Added', [
                                new Str('item 1'),
                                new Str('item 2'),
                            ]),
                        ],
                    )
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseParser::parse
     *
     * @dataProvider providerForTestParse
     */
    public function testParse(string $str, array $expected): void
    {
        $parser = new ReleaseParser();

        self::assertEquals(
            $expected,
            $parser->parse(Str::make($str)),
        );
    }

    public static function providerForTestParseTags(): array
    {
        return [
            [
                'str' => "## v1.0.2 super release\n## v1.0.1 super release\n## v1.0.0 super release",
                'expected' => [
                    'v1.0.2',
                    'v1.0.1',
                    'v1.0.0',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseParser::parseTags
     *
     * @dataProvider providerForTestParseTags
     */
    public function testParseTags(string $str, array $expected): void
    {
        self::assertEquals(
            $expected,
            (new ReleaseParser())->parseTags(Str::make($str)),
        );
    }
}
