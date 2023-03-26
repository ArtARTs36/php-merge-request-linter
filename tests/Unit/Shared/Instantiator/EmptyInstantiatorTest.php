<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Instantiator\EmptyInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EmptyInstantiatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\EmptyInstantiator::construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\EmptyInstantiator::__construct
     */
    public function testConstruct(): void
    {
        $constructor = new EmptyInstantiator(SuccessRule::class);

        $result = $constructor->construct([]);

        self::assertInstanceOf(SuccessRule::class, $result);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\EmptyInstantiator::params
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\EmptyInstantiator::__construct
     */
    public function testParams(): void
    {
        $constructor = new EmptyInstantiator(SuccessRule::class);

        self::assertEquals([], $constructor->params());
    }
}
