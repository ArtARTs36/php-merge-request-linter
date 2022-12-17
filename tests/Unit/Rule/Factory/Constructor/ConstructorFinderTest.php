<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\EmptyConstructor;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\NativeConstructor;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\StaticConstructor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConstructorFinderTest extends TestCase
{
    public function providerForTestFind(): array
    {
        return [
            [
                TestRuleForEmptyConstructor::class,
                EmptyConstructor::class,
            ],
            [
                TestRuleForNativeConstructor::class,
                NativeConstructor::class,
            ],
            [
                TestRuleForStaticConstructor::class,
                StaticConstructor::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder::find
     * @dataProvider providerForTestFind
     * @param class-string<Rule> $ruleClass
     * @param class-string<RuleConstructor> $expectedConstructorClass
     */
    public function testFind(string $ruleClass, string $expectedConstructorClass): void
    {
        $finder = new ConstructorFinder();

        self::assertInstanceOf($expectedConstructorClass, $finder->find($ruleClass));
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
