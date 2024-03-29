<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Text\Ssh;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class RsaKeyFinderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder::findFirst
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder::stringHasSshKey
     *
     * @dataProvider providerForTestFindFirst
     */
    public function testFindFirst(string $content, ?string $expectedType): void
    {
        $finder = new RsaKeyFinder();

        self::assertEquals($expectedType, $finder->findFirst(Str::make($content)));
    }

    public function providerForTestFindFirst(): array
    {
        return [
            [
                'ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAklOUpkDHrfHY17SbrmTIpNLTGK9Tjom/BWDSUGPl+nafzlHDTYW7hdI4yZ5ew18JH4JW9jbhUFrviQzM7xlELEVf4h9lFX5QVkbPppSwg0cda3Pbv7kOdJ/MTyBlWXFCR+HAo3FXRitBqxiX1nKhXpHAZsMciLq8V6RjsNAQwdsdMFvSlVK/7XAt3FaoJoAsncM1Q9x5+3V0Ww68/eIFmb1zuUFljQJKprrX88XypNDvjYNby6vw/Pb0rwert/EnmZ+AW4OZPnTPI89ZPmVMLuayrD2cE86Z/il8b+gw3r3+1nKatmIkjn2so1d01QraTlMqVSsbxNrRFi9wrf+M7Q== schacon@mylaptop.local',
                'ssh-rsa',
            ],
            [
                'fwerfwefwerfwe',
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder::findAll
     *
     * @dataProvider providerForTestFindAll
     */
    public function testFindAll(string $text, array $expectedTypes): void
    {
        $finder = new RsaKeyFinder();

        self::assertEquals($expectedTypes, $finder->findAll(Str::make($text)));
    }

    public function providerForTestFindAll(): array
    {
        return [
            [
                'ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAklOUpkDHrfHY17SbrmTIpNLTGK9Tjom/BWDSUGPl+nafzlHDTYW7hdI4yZ5ew18JH4JW9jbhUFrviQzM7xlELEVf4h9lFX5QVkbPppSwg0cda3Pbv7kOdJ/MTyBlWXFCR+HAo3FXRitBqxiX1nKhXpHAZsMciLq8V6RjsNAQwdsdMFvSlVK/7XAt3FaoJoAsncM1Q9x5+3V0Ww68/eIFmb1zuUFljQJKprrX88XypNDvjYNby6vw/Pb0rwert/EnmZ+AW4OZPnTPI89ZPmVMLuayrD2cE86Z/il8b+gw3r3+1nKatmIkjn2so1d01QraTlMqVSsbxNrRFi9wrf+M7Q== schacon@mylaptop.local',
                ['ssh-rsa'],
            ],
            [
                'fwerfwefwerfwe',
                [],
            ],
        ];
    }
}
