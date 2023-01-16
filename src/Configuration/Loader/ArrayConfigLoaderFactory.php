<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\DefaultEvaluators;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EvaluatorFactory;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorFactory;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\ArrayLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Mapper\CredentialMapper;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Mapper\RulesMapper;
use ArtARTs36\MergeRequestLinter\Configuration\Value\EnvTransformer;
use ArtARTs36\MergeRequestLinter\Configuration\Value\FileTransformer;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\DefaultResolvers;
use ArtARTs36\MergeRequestLinter\Rule\Factory\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\RuleFactory;
use ArtARTs36\MergeRequestLinter\Support\Reflector\CallbackPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Support\Text\DecoderFactory;

class ArrayConfigLoaderFactory
{
    public const SUPPORT_FORMATS = [
        'json' => true,
        'yaml' => true,
    ];

    public function __construct(
        private readonly FileSystem $fileSystem,
        private readonly Environment $environment,
        private readonly MetricManager $metrics,
        private readonly DecoderFactory $decoderFactory = new DecoderFactory(),
    ) {
        //
    }

    public function create(ConfigFormat $format): ConfigLoader
    {
        if (! array_key_exists($format->value, self::SUPPORT_FORMATS)) {
            throw new \InvalidArgumentException(sprintf(
                'ConfigLoader for format "%s" not found. Expected one of: [%s]',
                $format->value,
                implode(', ', array_keys(self::SUPPORT_FORMATS)),
            ));
        }

        $ruleFactory = new RuleFactory(
            new Builder(
                DefaultResolvers::get(),
            ),
            new ConstructorFinder(),
        );

        $operatorFactory = new OperatorFactory(new CallbackPropertyExtractor(), new EvaluatorFactory(
            DefaultEvaluators::map(),
        ));

        $credentialMapper = new CredentialMapper(
            [
                new EnvTransformer($this->environment),
                new FileTransformer($this->fileSystem),
            ],
            DefaultSystems::map(),
        );

        $rulesMapper = new RulesMapper(
            new Resolver(DefaultRules::map(), $ruleFactory, ConditionRuleFactory::new(
                new OperatorResolver($operatorFactory),
                $this->metrics,
            )),
        );

        return new ArrayLoader($this->fileSystem, $this->decoderFactory->create($format->value), new ArrayConfigHydrator(
            $credentialMapper,
            $rulesMapper,
        ));
    }
}
