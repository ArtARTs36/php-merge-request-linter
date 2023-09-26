<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\ToolInfo\InfoSubject;

use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\StringSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class StringSubjectTest extends TestCase
{
    public function providerForTestDescribe(): array
    {
        return [
            [
                'Developer',
                'name',
                'Developer: name',
            ],
            [
                'QA',
                'name2',
                'QA: name2',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\StringSubject::describe
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\StringSubject::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(string $theme, string $value, string $expected): void
    {
        $subject = new StringSubject($theme, $value);

        self::assertEquals($expected, $subject->describe());
    }
}
