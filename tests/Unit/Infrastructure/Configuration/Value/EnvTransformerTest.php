<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\InvalidConfigValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::transform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::doTransform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::__construct
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::supports
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::__construct
     * @dataProvider providerForTestSupports
     */
    public function testSupports(string $input, bool $expected): void
    {
        $transformer = new EnvTransformer(new MapEnvironment(new ArrayMap([])));

        self::assertEquals($expected, $transformer->supports($input));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::transform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::doTransform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer::__construct
     */
    public function testTransformOnEnvNotFound(): void
    {
        $transformer = new EnvTransformer(new MapEnvironment(new ArrayMap([])));

        self::expectException(InvalidConfigValueException::class);

        $transformer->transform('var');
    }
}
