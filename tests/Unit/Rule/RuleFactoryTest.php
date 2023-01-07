<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\AbstractRule;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\RuleFactory;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class RuleFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new RuleFactory(
            new Builder([
                Map::class => new MapResolver(),
                'string' => new AsIsResolver(),
                'int' => new AsIsResolver(),
                'float' => new AsIsResolver(),
            ]),
            new ConstructorFinder(),
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
        public Map $values,
        public int $prop,
    ) {
        //
    }

    public function doLint(MergeRequest $request): bool
    {
        // TODO: Implement lint() method.
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}
