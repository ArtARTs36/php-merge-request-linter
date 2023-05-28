<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\AbstractRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\ParameterMapBuilder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RuleFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new RuleFactory(
            new ParameterMapBuilder(new CompositeResolver([
                'string' => new AsIsResolver(),
                'int' => new AsIsResolver(),
                'float' => new AsIsResolver(),
                'array' => new AsIsResolver(),
                'object' => new ObjectCompositeResolver([
                    Map::class => new MapResolver(),
                    ArrayMap::class => new MapResolver(),
                ]),
            ])),
            new Finder(),
        );

        $rule = $factory->create(TestRuleForRuleFactory::class, [
            'values' => [1, 2],
            'prop' => 2,
        ]);

        self::assertEquals(2, $rule->prop);
    }
}

class TestRuleForRuleFactory extends AbstractRule
{
    public function __construct(
        public ArrayMap $values,
        public int      $prop,
    ) {
        //
    }

    public function doLint(MergeRequest $request): bool
    {
        return true;
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}
