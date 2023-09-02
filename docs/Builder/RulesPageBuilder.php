<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\JsonType;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\RuleParamMetadata;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\RulesMetadataLoader;
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
        private RulesMetadataLoader $rulesMetadataLoader = new RulesMetadataLoader(),
    ) {
        //
    }

    public function build(): string
    {
        $rules = [];
        $metadata = $this->rulesMetadataLoader->load();

        foreach ($metadata->rules as $rule) {
            if ($rule->class === CustomRule::class) {
                continue;
            }

            $ruleHasParamsExamples = false;
            $params = $this->buildParams($rule->params, $ruleHasParamsExamples);

            $rules[] = [
                'name' => $rule->name,
                'params' => new Arrayee($params),
                'has_params_examples' => $ruleHasParamsExamples,
                'description' => $rule->description,
            ];
        }

        return TwigRenderer::create()->render(
            file_get_contents(__DIR__ . '/templates/rules.md.twig'),
            [
                'rules' => new Arrayee($rules),
            ],
        );
    }

    /**
     * @param array<RuleParamMetadata> $metadataParams
     */
    private function buildParams(array $metadataParams, bool &$ruleHasParamsExamples): array
    {
        $params = [];

        foreach ($metadataParams as $param) {
            $paramType = JsonType::to($param->type->name());

            if ($paramType === null) {
                continue;
            }

            $examples = new Arrayee($param->examples);

            if (! $examples->isEmpty()) {
                $ruleHasParamsExamples = true;
            }

            $params[] = [
                'name' => $param->name,
                'type' => $paramType,
                'generic' => $param->type->isGeneric() ? JsonType::to($param->type->generic) : null,
                'description' => $param->description,
                'examples' => $examples,
                'isGenericObject' => $param->type->generic && class_exists($param->type->generic),
            ];
        }

        return $params;
    }
}
