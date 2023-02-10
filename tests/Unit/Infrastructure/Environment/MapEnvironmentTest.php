<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Environment;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapEnvironmentTest extends TestCase
{
    public function providerForTestGetString(): array
    {
        return [
            [
                ['var_1' => 123],
                'var_1',
                '123',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetString
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::__construct
     */
    public function testGetString(array $assigment, string $key, string $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new ArrayMap($assigment)))->getString($key));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::__construct
     */
    public function testGetStringOnNotFound(): void
    {
        self::expectException(VarNotFoundException::class);

        (new MapEnvironment(new ArrayMap([])))->getString('local_environment_test_var_not_found');
    }

    public function providerForTestGetInt(): array
    {
        return [
            [
                ['var_2' => 123],
                'var_2',
                123,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetInt
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::__construct
     */
    public function testGetInt(array $assigment, string $key, int $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new ArrayMap($assigment)))->getInt($key));
    }

    public function providerForTestHas(): array
    {
        return [
            [
                ['var_3' => 123, 'var_4' => 'str'],
                'var_3',
                true,
            ],
            [
                ['var_3' => 123, 'var_4' => 'str'],
                'var_not_exists',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHas
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::has
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment::__construct
     */
    public function testHas(array $assigment, string $key, bool $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new ArrayMap($assigment)))->has($key));
    }
}
