<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Environment;

use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChainEnvironmentTest extends TestCase
{
    public function providerForTestGetString(): array
    {
        return [
            [
                [
                    new MapEnvironment(new ArrayMap([])),
                    new MapEnvironment(new ArrayMap([
                        'k1' => 'v1',
                    ])),
                ],
                'k1',
                'v1',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::__construct
     * @dataProvider providerForTestGetString
     */
    public function testGetString(array $subEnvs, string $key, string $expectedValue): void
    {
        $environment = new ChainEnvironment($subEnvs);

        self::assertEquals($expectedValue, $environment->getString($key));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::getString
     */
    public function testGetStringOnVarNotFound(): void
    {
        $environment = new ChainEnvironment([
            new MapEnvironment(new ArrayMap([])),
            new MapEnvironment(new ArrayMap([])),
        ]);

        self::expectException(VarNotFoundException::class);

        $environment->getString('k1');
    }

    public function providerForTestGetInt(): array
    {
        return [
            [
                [
                    new MapEnvironment(new ArrayMap([])),
                    new MapEnvironment(new ArrayMap([
                        'k1' => 1,
                    ])),
                ],
                'k1',
                1,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::__construct
     * @dataProvider providerForTestGetInt
     */
    public function testGetInt(array $subEnvs, string $key, int $expectedValue): void
    {
        $environment = new ChainEnvironment($subEnvs);

        self::assertEquals($expectedValue, $environment->getInt($key));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::getInt
     */
    public function testGetIntOnVarNotFound(): void
    {
        $environment = new ChainEnvironment([
            new MapEnvironment(new ArrayMap([])),
            new MapEnvironment(new ArrayMap([])),
        ]);

        self::expectException(VarNotFoundException::class);

        $environment->getInt('k1');
    }

    public function providerForTestHas(): array
    {
        return [
            [
                [
                    new MapEnvironment(new ArrayMap([])),
                    new MapEnvironment(new ArrayMap([
                        'k1' => 1,
                    ])),
                ],
                'k1',
                true,
            ],
            [
                [
                    new MapEnvironment(new ArrayMap([])),
                    new MapEnvironment(new ArrayMap([])),
                ],
                'k2',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::has
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment::__construct
     * @dataProvider providerForTestHas
     */
    public function testHas(array $subEnvs, string $key, bool $expected): void
    {
        $environment = new ChainEnvironment($subEnvs);

        self::assertEquals($expected, $environment->has($key));
    }
}
