<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\Tests\TestFor;
use ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules\RuleTestDataSet;

class RuleTestDataSetsLoader
{
    /**
     * @return array<string, array<RuleTestDataSet>>
     */
    public function load(): array
    {
        $ruleTests = (new ClassFinder())->find('RuleTest');

        $datasets = [];

        foreach ($ruleTests as $testClass) {
            $classReflector = new \ReflectionClass($testClass);

            $ruleClassAttribute = current($classReflector->getAttributes(TestFor::class));

            if ($ruleClassAttribute === false) {
                continue;
            }

            $ruleClass = $ruleClassAttribute->getArguments()[0];

            $test = $classReflector->newInstanceWithoutConstructor();

            foreach ($test->providerForTestLint() as $ruleSets) {
                $datasets[$ruleClass][] = $ruleSets[0];
            }
        }

        return $datasets;
    }
}
