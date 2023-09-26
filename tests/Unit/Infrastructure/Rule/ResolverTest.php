<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CompositeRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NonCriticalRule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\CreatingRuleException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\NullCounter;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\ParameterMapBuilder;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockTypeResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class ResolverTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::__construct
     */
    public function testResolveOnRuleNotFound(): void
    {
        $resolver = new Resolver(new ArrayMap([
            'success' => SuccessRule::class,
        ]), new RuleFactory(new ParameterMapBuilder(new MockTypeResolver()), new Finder()), new ConditionRuleFactory(new MockOperatorResolver(), new NullCounter()));

        self::expectException(RuleNotFound::class);

        $resolver->resolve('warning', []);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRuleOnManyConfigurations
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveOnManyConfigurations(): void
    {
        $resolver = new Resolver(new ArrayMap([
            'success' => SuccessRule::class,
        ]), new RuleFactory(new ParameterMapBuilder(new MockTypeResolver()), new Finder()), new ConditionRuleFactory(new MockOperatorResolver(), new NullCounter()));

        $gotRule = $resolver->resolve('success', [
            [
                'var' => 1,
            ],
            [
                'var' => 2,
            ],
        ]);

        self::assertInstanceOf(CompositeRule::class, $gotRule);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveNonCriticalRule(): void
    {
        $resolver = new Resolver(new ArrayMap([
            'success' => SuccessRule::class,
        ]), new RuleFactory(new ParameterMapBuilder(new MockTypeResolver()), new Finder()), new ConditionRuleFactory(new MockOperatorResolver(), new NullCounter()));

        $gotRule = $resolver->resolve('success', ['critical' => false]);

        self::assertInstanceOf(NonCriticalRule::class, $gotRule);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveOnCriticalParamNonBoolean(): void
    {
        $resolver = new Resolver(new ArrayMap([
            'success' => SuccessRule::class,
        ]), new RuleFactory(new ParameterMapBuilder(new MockTypeResolver()), new Finder()), new ConditionRuleFactory(new MockOperatorResolver(), new NullCounter()));

        self::expectExceptionMessage('Failed to create Rule with name "success": param "critical" must be boolean');

        $resolver->resolve('success', ['critical' => 'non-boolean']);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveConditionRule(): void
    {
        $resolver = new Resolver(
            new ArrayMap([
                'success' => SuccessRule::class,
            ]),
            new RuleFactory(
                new ParameterMapBuilder(
                    new MockTypeResolver()
                ),
                new Finder(),
            ),
            new ConditionRuleFactory(new MockOperatorResolver(MockConditionOperator::true()), new NullCounter()),
        );

        $gotRule = $resolver->resolve('success', ['when' => [
            'prop' => [
                'equals' => 1,
            ],
        ]]);

        self::assertInstanceOf(ConditionRule::class, $gotRule);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveOnParamWhenNonArray(): void
    {
        $resolver = new Resolver(
            new ArrayMap([
                'success' => SuccessRule::class,
            ]),
            new RuleFactory(
                new ParameterMapBuilder(
                    new MockTypeResolver()
                ),
                new Finder(),
            ),
            new ConditionRuleFactory(new MockOperatorResolver(MockConditionOperator::true()), new NullCounter()),
        );

        self::expectExceptionMessage('Config[rules.success.when] has invalid type. Expected type: array, actual: string');

        $resolver->resolve('success', ['when' => 'non-array']);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver::resolveRule
     */
    public function testResolveOnFactoryWhenFailed(): void
    {
        $ruleFactory = $this->createMock(RuleFactory::class);
        $ruleFactory
            ->expects(new InvokedCount(1))
            ->method('create')
            ->willThrowException(new \Exception());

        $resolver = new Resolver(
            new ArrayMap([
                'success' => SuccessRule::class,
            ]),
            $ruleFactory,
            new ConditionRuleFactory(new MockOperatorResolver(MockConditionOperator::true()), new NullCounter()),
        );

        self::expectException(CreatingRuleException::class);

        $resolver->resolve('success', []);
    }
}
