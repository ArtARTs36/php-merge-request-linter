<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\AbstractRule;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\ScalarResolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\RuleFactory;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class RuleFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new RuleFactory(new Builder([
            Map::class => new MapResolver(),
            'string' => new ScalarResolver(),
            'int' => new ScalarResolver(),
            'float' => new ScalarResolver(),
        ]));

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

    public function lint(MergeRequest $request): array
    {
        // TODO: Implement lint() method.
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}
