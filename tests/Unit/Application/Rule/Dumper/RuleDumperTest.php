<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Dumper;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleInfo;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\FailRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RuleDumperTest extends TestCase
{
    public function providerForTestDump(): array
    {
        return [
            [
                [
                    new SuccessRule(),
                    new TestRuleDecorator([
                        new FailRule(),
                    ]),
                ],
                [
                    new RuleInfo('Success rule', SuccessRule::class),
                    new RuleInfo('Fail rule', FailRule::class),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper::dump
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper::doDump
     * @dataProvider providerForTestDump
     */
    public function testDump(array $rules, array $expect): void
    {
        $dumper = new RuleDumper();

        self::assertEquals($expect, $dumper->dump($rules));
    }
}

final class TestRuleDecorator implements RuleDecorator
{
    public function __construct(
        private array $decorated,
    ) {
        //
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getDecoratedRules(): array
    {
        return $this->decorated;
    }

    public function lint(MergeRequest $request): array
    {
        // TODO: Implement lint() method.
    }
}
