<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\RuleName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RuleNameTest extends TestCase
{
    public function providerForTestByClass(): array
    {
        return [
            [
                'Namespace\\Foo\\Bar\\ExampleRule',
                'example',
            ],
            [
                'Namespace\\Foo\\Bar\\ExampleTwoRule',
                'example_two',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestByClass
     * @covers RuleName::fromClass
     */
    public function testByClass(string $class, string $expected): void
    {
        self::assertEquals($expected, RuleName::fromClass($class));
    }
}
