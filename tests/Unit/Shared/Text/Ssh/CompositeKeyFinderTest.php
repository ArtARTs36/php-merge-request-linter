<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Text\Ssh;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;
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
                '',
                null,
            ],
            [
                [
                    new SshKeyFinderMock([]),
                ],
                '',
                null,
            ],
            [
                [
                    new SshKeyFinderMock([
                        'ssh-rsa1-text' => ['ssh-key-type-1'],
                    ]),
                    new SshKeyFinderMock([
                        'ssh-rsa1-text' => ['ssh-key-type-2'],
                    ]),
                ],
                'ssh-rsa1-text',
                'ssh-key-type-1',
            ],
            [
                [
                    new SshKeyFinderMock([]),
                    new SshKeyFinderMock([
                        'ssh-rsa1-text' => ['ssh-rsa2'],
                    ]),
                ],
                'ssh-rsa1-text',
                'ssh-rsa2',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder::findFirst
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder::__construct
     *
     * @dataProvider providerForTestFindFirst
     */
    public function testFindFirst(array $subFinders, string $text, ?string $expectedType): void
    {
        $finder = new CompositeKeyFinder($subFinders);

        self::assertEquals($expectedType, $finder->findFirst(Str::make($text)));
    }

    public function providerForTestFindAll(): array
    {
        return [
            [
                [],
                '',
                [],
            ],
            [
                [
                    new SshKeyFinderMock([
                        'ssh-key-text' => [
                            'type1',
                            'type2',
                        ],
                    ]),
                ],
                'ssh-key-text',
                [
                    'type1',
                    'type2',
                ],
            ],
            [
                [
                    new SshKeyFinderMock([
                        'ssh-key-text' => [
                            'type1',
                            'type2',
                        ],
                    ]),
                    new SshKeyFinderMock([]),
                    new SshKeyFinderMock([
                        'ssh-key-text' => [
                            'type3',
                            'type4',
                        ],
                    ]),
                ],
                'ssh-key-text',
                [
                    'type1',
                    'type2',
                    'type3',
                    'type4',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder::findAll
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder::__construct
     *
     * @dataProvider providerForTestFindAll
     *
     * @param array<SshKeyFinder> $subFolders
     * @param array<string> $expectedTypes
     */
    public function testFindAll(array $subFolders, string $text, array $expectedTypes): void
    {
        $finder = new CompositeKeyFinder($subFolders);

        self::assertEquals($expectedTypes, $finder->findAll(Str::make($text)));
    }
}
