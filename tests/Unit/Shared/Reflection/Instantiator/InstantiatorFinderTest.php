<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Instantiator;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\EmptyInstantiator;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Instantiator;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\NativeConstructorInstantiator;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\StaticMethodInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class InstantiatorFinderTest extends TestCase
{
    public function providerForTestFind(): array
    {
        return [
            [
                TestRuleForEmptyConstructor::class,
                EmptyInstantiator::class,
            ],
            [
                TestRuleForNativeConstructor::class,
                NativeConstructorInstantiator::class,
            ],
            [
                TestRuleForStaticConstructor::class,
                StaticMethodInstantiator::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder::find
     * @dataProvider providerForTestFind
     * @param class-string<Rule> $ruleClass
     * @param class-string<Instantiator> $expectedConstructorClass
     */
    public function testFind(string $ruleClass, string $expectedConstructorClass): void
    {
        $finder = new Finder();

        self::assertInstanceOf($expectedConstructorClass, $finder->find($ruleClass));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder::find
     */
    public function testFindOnClassNonExists(): void
    {
        $finder = new Finder();

        self::expectExceptionMessage('Class "test-class" not found');

        $finder->find('test-class');
    }
}

class TestRuleForEmptyConstructor
{
}

class TestRuleForNativeConstructor extends TestRuleForEmptyConstructor
{
    public function __construct()
    {
        //
    }
}

class TestRuleForStaticConstructor extends TestRuleForEmptyConstructor
{
    public static function make(): self
    {
        return new self();
    }
}
