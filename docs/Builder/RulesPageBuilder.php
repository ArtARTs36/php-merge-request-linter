<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\JsonType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ClassSummary;

class RulesPageBuilder
{
    protected string $namespace = 'ArtARTs36\MergeRequestLinter\\Application\\Rule\\Rules\\';

    protected string $dir = __DIR__ . '/../../src/Application/Rule/Rules';

    public function __construct(
        private RuleConstructorFinder $ruleConstructorFinder = new ConstructorFinder(),
        private RuleTestDataSetsLoader $ruleTestDataSetsLoader = new RuleTestDataSetsLoader(),
    ) {
        //
    }

    public function build(): string
    {
        $rules = [];

        $testDataSets = $this->ruleTestDataSetsLoader->load();

        foreach (DefaultRules::map() as $ruleName => $ruleClass) {
            if ($ruleClass === CustomRule::class) {
                continue;
            }

            $reflector = new \ReflectionClass($ruleClass);

            $comment = ClassSummary::findInPhpDocComment($reflector->getDocComment());

            $path = '..' . str_replace(dirname(__DIR__, 2), '', $reflector->getFileName());

            $params = [];

            foreach ($this->ruleConstructorFinder->find($ruleClass)->params() as $paramName => $param) {
                $params[] = [
                    'name' => $paramName,
                    'type' => JsonType::to($param->name()),
                    'generic' => $param->isGeneric() ? JsonType::to($param->generic) : null,
                ];
            }

            $rules[] = [
                'name' => $ruleName,
                'params' => $params,
                'description' => $comment,
                'path' => $path,
                'tests' => $testDataSets[$ruleClass] ?? [],
            ];
        }

        return TwigRenderer::create()->render(
            file_get_contents(__DIR__ . '/templates/rules.md.twig'),
            new ArrayMap([
                'rules' => $rules,
            ])
        );
    }
}
