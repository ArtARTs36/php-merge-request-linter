<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EmptyConstructorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor::construct
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor::__construct
     */
    public function testConstruct(): void
    {
        $constructor = new EmptyConstructor(SuccessRule::class);

        $result = $constructor->construct([]);

        self::assertInstanceOf(SuccessRule::class, $result);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor::params
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor::__construct
     */
    public function testParams(): void
    {
        $constructor = new EmptyConstructor(SuccessRule::class);

        self::assertEquals([], $constructor->params());
    }
}
