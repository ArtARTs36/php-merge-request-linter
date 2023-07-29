<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Text\Ssh;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SshKeyFinderMock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class CompositeKeyFinderTest extends TestCase
{
    public function providerForTestFindFirst(): array
    {
        return [
            [
                [],
                null,
            ],
            [
                [
                    new SshKeyFinderMock([]),
                ],
                null,
            ],
            [
                [
                    new SshKeyFinderMock(['ssh-rsa1']),
                    new SshKeyFinderMock(['ssh-rsa2']),
                ],
                'ssh-rsa1',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder::findFirst
     *
     * @dataProvider providerForTestFindFirst
     */
    public function testFindFirst(array $subFinders, ?string $expectedType): void
    {
        $finder = new CompositeKeyFinder($subFinders);

        self::assertEquals($expectedType, $finder->findFirst(Str::fromEmpty()));
    }
}
