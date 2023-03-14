<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\DefaultEvaluators;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule\OperatorRulesExecutor;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule\RulesExecutor;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ChainFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\EvaluatorFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\OperatorFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\CiSettingsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\RulesMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\CompositeTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\EnvTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\ArgumentResolverFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;

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
        private readonly ArgumentResolverFactory $argumentResolverFactory,
        private readonly MapContainer $container,
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
                $this->argumentResolverFactory->create(),
            ),
            new ConstructorFinder(),
        );

        $propExtractor = new CallbackPropertyExtractor();

        $subjectFactory = new SubjectFactory($propExtractor);

        $evaluatorCreatorChain = (new ChainFactory(DefaultEvaluators::map(), $subjectFactory))->create();

        $operatorFactory = new OperatorFactory($subjectFactory, new EvaluatorFactory($evaluatorCreatorChain));

        $this->container->set(OperatorFactory::class, $operatorFactory);
        $this->container->set(\ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver::class, $opResolver = new OperatorResolver($operatorFactory));
        $this->container->set(RulesExecutor::class, new OperatorRulesExecutor($opResolver));

        $valueTransformers = [
            new EnvTransformer($this->environment),
            new FileTransformer($this->fileSystem),
        ];

        $compositeValueTransformer = new CompositeTransformer($valueTransformers);

        $credentialMapper = new CiSettingsMapper(
            [
                GithubActions::NAME => new GithubActionsCredentialsMapper($compositeValueTransformer),
                GitlabCi::NAME => new GitlabCredentialsMapper($compositeValueTransformer),
                BitbucketPipelines::NAME => new BitbucketCredentialsMapper($compositeValueTransformer),
            ],
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
            new NotificationsMapper(
                $valueTransformers,
            ),
        ));
    }
}
