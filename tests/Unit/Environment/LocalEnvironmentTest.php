<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Environment;

use ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LocalEnvironmentTest extends TestCase
{
    public function providerForTestGetString(): array
    {
        return [
            [
                'local_environment_test_var_1=123',
                'local_environment_test_var_1',
                '123',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetString
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::doGet
     */
    public function testGetString(string $assigment, string $key, string $expected): void
    {
        putenv($assigment);

        self::assertEquals($expected, (new LocalEnvironment())->getString($key));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::getString
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::doGet
     */
    public function testGetStringOnNotFound(): void
    {
        self::expectException(EnvironmentVariableNotFound::class);

        (new LocalEnvironment())->getString('local_environment_test_var_not_found');
    }

    public function providerForTestGetInt(): array
    {
        return [
            [
                'local_environment_test_var_2=123',
                'local_environment_test_var_2',
                123,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetInt
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::get
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::doGet
     */
    public function testGetInt(string $assigment, string $key, int $expected): void
    {
        putenv($assigment);

        self::assertEquals($expected, (new LocalEnvironment())->getInt($key));
    }

    public function providerForTestHas(): array
    {
        return [
            [
                "local_environment_test_var_3=123\nlocal_environment_test_var_4=str",
                'local_environment_test_var_3',
                true,
            ],
            [
                "local_environment_test_var_3=123\nlocal_environment_test_var_4=str",
                'local_environment_test_var_not_exists',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHas
     * @covers \ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment::has
     */
    public function testHas(string $assigment, string $key, bool $expected): void
    {
        putenv($assigment);

        self::assertEquals($expected, (new LocalEnvironment())->has($key));
    }
}
