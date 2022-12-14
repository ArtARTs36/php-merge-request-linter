<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Environment;

use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
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
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::__construct
     */
    public function testGetString(array $assigment, string $key, string $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new Map($assigment)))->getString($key));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::__construct
     */
    public function testGetStringOnNotFound(): void
    {
        self::expectException(EnvironmentVariableNotFound::class);

        (new MapEnvironment(new Map([])))->getString('local_environment_test_var_not_found');
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
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::doGet
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::__construct
     */
    public function testGetInt(array $assigment, string $key, int $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new Map($assigment)))->getInt($key));
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
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::has
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\MapEnvironment::__construct
     */
    public function testHas(array $assigment, string $key, bool $expected): void
    {
        self::assertEquals($expected, (new MapEnvironment(new Map($assigment)))->has($key));
    }
}
