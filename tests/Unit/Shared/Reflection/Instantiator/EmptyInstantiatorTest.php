<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EmptyInstantiatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator::instantiate
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator::__construct
     */
    public function testInstantiate(): void
    {
        $constructor = new EmptyInstantiator(SuccessRule::class);

        $result = $constructor->instantiate([]);

        self::assertInstanceOf(SuccessRule::class, $result);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator::params
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator::__construct
     */
    public function testParams(): void
    {
        $constructor = new EmptyInstantiator(SuccessRule::class);

        self::assertEquals([], $constructor->params());
    }
}
