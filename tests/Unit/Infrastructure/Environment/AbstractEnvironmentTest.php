<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Environment;

use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\AbstractEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AbstractEnvironmentTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\AbstractEnvironment::getInt
     */
    public function testGetIntOk(): void
    {
        $environment = new DummyEnvironment(1);

        self::assertEquals(1, $environment->getInt('VAR'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\AbstractEnvironment::getInt
     */
    public function testGetIntOnInvalidType(): void
    {
        $environment = new DummyEnvironment('AB');

        self::expectException(VarHasDifferentTypeException::class);

        $environment->getInt('VAR');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\AbstractEnvironment::getString
     */
    public function testGetStringOk(): void
    {
        $environment = new DummyEnvironment('string-val');

        self::assertEquals('string-val', $environment->getString('VAR'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\AbstractEnvironment::getString
     */
    public function testGetStringOnInvalidType(): void
    {
        $environment = new DummyEnvironment([]);

        self::expectException(VarHasDifferentTypeException::class);

        $environment->getString('VAR');
    }
}

class DummyEnvironment extends AbstractEnvironment
{
    public function __construct(
        private mixed $value,
    ) {
        //
    }

    protected function get(string $key): mixed
    {
        return $this->value;
    }
}
