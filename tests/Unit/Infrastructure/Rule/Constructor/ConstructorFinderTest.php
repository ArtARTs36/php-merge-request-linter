<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Constructor;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\EmptyConstructor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\NativeConstructor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\StaticConstructor;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder::find
     * @dataProvider providerForTestFind
     * @param class-string<Rule> $ruleClass
     * @param class-string<RuleConstructor> $expectedConstructorClass
     */
    public function testFind(string $ruleClass, string $expectedConstructorClass): void
    {
        $finder = new ConstructorFinder();

        self::assertInstanceOf($expectedConstructorClass, $finder->find($ruleClass));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder::find
     */
    public function testFindOnClassNonExists(): void
    {
        $finder = new ConstructorFinder();

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
