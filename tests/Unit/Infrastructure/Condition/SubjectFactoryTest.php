<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\StaticEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SubjectFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\SubjectFactory::createForValue
     */
    public function testForCreateForValue(): void
    {
        $factory = new SubjectFactory(new MockPropertyExtractor(''));

        self::assertInstanceOf(StaticEvaluatingSubject::class, $factory->createForValue('', ''));
    }
}
