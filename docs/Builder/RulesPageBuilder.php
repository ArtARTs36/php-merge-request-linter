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
    private function buildParams(array $metadataParams, bool &$ruleHasParamsExamples, string $prefix = ''): array
    {
        $params = [];

        foreach ($metadataParams as $param) {
            if ($param->jsonType === null) {
                continue;
            }

            if (count($param->enum) > 0) {
                $examples = new Arrayee($param->enum);
            } else {
                $examples = new Arrayee($param->examples);
            }

            if (! $examples->isEmpty()) {
                $ruleHasParamsExamples = true;
            }

            $name = $param->name;

            if ($prefix !== '') {
                $name = $prefix . '.' . $param->name;
            }

            $params[] = [
                'name' => $name,
                'type' => $param->jsonType,
                'generic' => $param->type->isGeneric() ? JsonType::to($param->type->generic) : null,
                'description' => $param->description,
                'examples' => $examples,
                'isGenericObject' => $param->type->generic && class_exists($param->type->generic),
            ];

            if ($param->type->isGeneric()) {
                $genericName = $name . '.*';

                if ($prefix !== '') {
                    $genericName = $name . '.' . $genericName;
                }

                $objGeneric = $param->type->getObjectGeneric();

                if ($objGeneric !== null) {
                    $params[] = [
                        'name' => $genericName,
                        'type' => $param->jsonType,
                        'generic' => $param->type->isGeneric() ? JsonType::to($param->type->generic) : null,
                        'description' => $param->description,
                        'examples' => $examples,
                        'isGenericObject' => $param->type->generic && class_exists($param->type->generic),
                    ];

                    $params = array_merge($params, $this->buildParams(
                        $param->genericObjectParams,
                        $ruleHasParamsExamples,
                        $genericName,
                    ));
                }
            } else {
                $params = array_merge($params, $this->buildParams(
                    $param->nestedObjectParams,
                    $ruleHasParamsExamples,
                    $name,
                ));
            }
        }

        return $params;
    }
}
