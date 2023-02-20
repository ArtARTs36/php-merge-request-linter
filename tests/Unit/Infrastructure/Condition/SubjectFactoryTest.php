<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\PropertyEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\StaticEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SubjectFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory::createForValue
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory::__construct
     */
    public function testForCreateForValue(): void
    {
        $factory = new SubjectFactory(new MockPropertyExtractor(''));

        self::assertInstanceOf(StaticEvaluatingSubject::class, $factory->createForValue('', ''));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory::createForProperty
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory::__construct
     */
    public function testForCreateForProperty(): void
    {
        $factory = new SubjectFactory(new MockPropertyExtractor(''));

        self::assertInstanceOf(PropertyEvaluatingSubject::class, $factory->createForProperty(
            (object) ['title' => 'test'],
            'title',
        ));
    }
}
