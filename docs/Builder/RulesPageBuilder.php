<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\JsonType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\InstantiatorFinder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\ClassSummary;

class RulesPageBuilder
{
    protected string $namespace = 'ArtARTs36\MergeRequestLinter\\Application\\Rule\\Rules\\';

    protected string $dir = __DIR__ . '/../../src/Application/Rule/Rules';

    public function __construct(
        private InstantiatorFinder $ruleConstructorFinder = new Finder(),
    ) {
        //
    }

    public function build(): string
    {
        $rules = [];

        foreach (DefaultRules::map() as $ruleName => $ruleClass) {
            if ($ruleClass === CustomRule::class) {
                continue;
            }

            $reflector = new \ReflectionClass($ruleClass);

            $comment = ClassSummary::findInPhpDocComment($reflector->getDocComment());

            $path = '..' . str_replace(dirname(__DIR__, 2), '', $reflector->getFileName());

            $params = [];

            foreach ($this->ruleConstructorFinder->find($ruleClass)->params() as $paramName => $param) {
                $paramType = JsonType::to($param->type->name());

                if ($paramType === null) {
                    continue;
                }

                $params[] = [
                    'name' => $paramName,
                    'type' => $paramType,
                    'generic' => $param->type->isGeneric() ? JsonType::to($param->type->generic) : null,
                    'description' => $param->description,
                ];
            }

            $rules[] = [
                'name' => $ruleName,
                'params' => new Arrayee($params),
                'description' => $comment,
                'path' => $path,
            ];
        }

        return TwigRenderer::create()->render(
            file_get_contents(__DIR__ . '/templates/rules.md.twig'),
            [
                'rules' => new Arrayee($rules),
            ],
        );
    }
}
