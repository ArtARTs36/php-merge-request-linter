<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\DefaultEvaluators;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EvaluatorFactory;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorFactory;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ArrayConfigLoaderFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\CompositeLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ConfigLoaderProxy;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\CredentialMapper;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\JsonConfigLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\PhpConfigLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\RulesMapper;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\PathResolver;
use ArtARTs36\MergeRequestLinter\Configuration\Value\EnvTransformer;
use ArtARTs36\MergeRequestLinter\Configuration\Value\FileTransformer;
use ArtARTs36\MergeRequestLinter\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InfoCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory as LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder as ConfigArgumentBuilder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\DefaultResolvers;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\RuleFactory;
use ArtARTs36\MergeRequestLinter\Support\Reflector\CallbackPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Support\ToolInfo\ToolInfoFactory;

class ApplicationFactory
{
    public function create(): Application
    {
        $application = new Application();

        $filesystem = new LocalFileSystem();
        $environment = new LocalEnvironment();
        $ciSystemsMap = DefaultSystems::map();
        $runnerFactory = new LinterRunnerFactory($environment, $ciSystemsMap);

        $arrayConfigLoaderFactory = new ArrayConfigLoaderFactory($filesystem, $environment);

        $configLoader = new CompositeLoader([
            'php' => new PhpConfigLoader($filesystem),
            'json' => new ConfigLoaderProxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::JSON)),
            'yaml' => new ConfigLoaderProxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
            'yml' => new ConfigLoaderProxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
        ]);

        $configResolver = new ConfigResolver(new PathResolver($filesystem), $configLoader);

        $application->add(new LintCommand($configResolver, $runnerFactory));
        $application->add(new InstallCommand());
        $application->add(new DumpCommand($configResolver));
        $application->add(new InfoCommand(new ToolInfoFactory()));

        return $application;
    }
}
