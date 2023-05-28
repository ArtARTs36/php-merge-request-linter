<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
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

class TestRuleForEmptyConstructor implements Rule
{
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function lint(MergeRequest $request): array
    {
        // TODO: Implement lint() method.
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
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
