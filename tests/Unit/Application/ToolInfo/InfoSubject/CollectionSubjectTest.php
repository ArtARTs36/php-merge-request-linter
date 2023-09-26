<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\ToolInfo\InfoSubject;

use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\CollectionSubject;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CollectionSubjectTest extends TestCase
{
    public function providerForTestDescribe(): array
    {
        return [
            [
                'Developer',
                ['name1', 'name2'],
                'Developer: [name1, name2]',
            ],
            [
                'QA',
                ['name1', 'name2'],
                'QA: [name1, name2]',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\CollectionSubject::describe
     * @covers \ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\CollectionSubject::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(string $theme, array $value, string $expected): void
    {
        $subject = new CollectionSubject($theme, new Arrayee($value));

        self::assertEquals($expected, $subject->describe());
    }
}
