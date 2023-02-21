<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\ToolInfo\InfoSubject;

use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\BoolSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BoolSubjectTest extends TestCase
{
    public function providerForTestDescribe(): array
    {
        return [
            [
                'Developer',
                true,
                'Developer: true',
            ],
            [
                'QA',
                false,
                'QA: false',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\BoolSubject::describe
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\BoolSubject::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(string $theme, bool $value, string $expected): void
    {
        $subject = new BoolSubject($theme, $value);

        self::assertEquals($expected, $subject->describe());
    }
}
