<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Configuration\Value\EnvTransformer;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EnvTransformerTest extends TestCase
{
    public function providerForTestTransform(): array
    {
        return [
            [
                [
                    'super-secret-password' => 'a1b2c3',
                ],
                'env(super-secret-password)',
                'a1b2c3',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Configuration\Value\EnvTransformer::transform
     * @dataProvider providerForTestTransform
     */
    public function testTransform(array $env, string $input, string $expected): void
    {
        $transformer = new EnvTransformer(new MapEnvironment(new ArrayMap($env)));

        self::assertEquals($expected, $transformer->transform($input));
    }

    public function providerForTestSupports(): array
    {
        return [
            [
                'env(super-secret-password)',
                true,
            ],
            [
                'aenv(super-secret-password)',
                false,
            ],
            [
                'scd',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Configuration\Value\EnvTransformer::supports
     * @dataProvider providerForTestSupports
     */
    public function testSupports(string $input, bool $expected): void
    {
        $transformer = new EnvTransformer(new MapEnvironment(new ArrayMap([])));

        self::assertEquals($expected, $transformer->supports($input));
    }
}
