<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\InstantiatorFinder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Reflector;

readonly class RulesMetadataLoader
{
    public function __construct(
        private InstantiatorFinder $instantiatorFinder = new Finder(),
    ) {
    }

    public function load(): RulesMetadata
    {
        $rules = DefaultRules::map();
        $metadataRules = [];

        foreach ($rules as $ruleName => $ruleClass) {
            $ruleReflector = new \ReflectionClass($ruleClass);

            $params = $this->buildParams($ruleClass);

            $metadataRules[$ruleName] = new RuleMetadata(
                $ruleName,
                $ruleClass,
                Reflector::findDescription($ruleReflector)?->description ?? '',
                $params,
            );
        }

        return new RulesMetadata(
            $metadataRules,
        );
    }

    /**
     * @param class-string $class
     * @return array<RuleParamMetadata>
     */
    private function buildParams(string $class): array
    {
        $constructor = $this->instantiatorFinder->find($class);
        $params = $constructor->params();
        $metadataParams = [];

        foreach ($params as $param) {
            if ($param->description === '')  {
                continue;
            }

            $enumValues = [];

            if ($param->type->class !== null && enum_exists($param->type->class)) {
                /** @var \BackedEnum $enum */
                $enum = $param->type->class;

                $enumValues = array_map(function (\UnitEnum $unit) {
                    return $unit->value;
                }, $enum::cases());
            }

            $nested = $param->type->isClass() && ! is_a($param->type->class, Collection::class, true) ?
                $this->buildParams($param->type->class) :
                [];

            $genericObject = [];

            if ($param->type->getObjectGeneric() !== null) {
                $genericObject = $this->buildParams($param->type->getObjectGeneric());
            }

            $metadataParams[$param->name] = new RuleParamMetadata(
                $param->name,
                $param->description,
                $param->isRequired(),
                $param->examples,
                $param->type,
                JsonType::to($param->type->class ?? $param->type->name->value),
                $enumValues,
                $nested,
                $genericObject,
                $param->hasDefaultValue ? $param->getDefaultValue() : null,
                $param->hasDefaultValue,
            );
        }

        return $metadataParams;
    }
}
