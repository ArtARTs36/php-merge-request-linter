<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Application;

use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\MergeRequestLinter\Application\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Common\File\Directory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\ArrayConfigLoaderFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\CompositeLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\PhpLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\MetricableConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\PathResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Linter\RunnerFactory as LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\ArgumentResolverFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InfoCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLoggerFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ApplicationFactory
{
    public function create(OutputInterface $output): Application
    {
        $metrics = new MemoryMetricManager();

        $application = new Application($metrics);

        $logger = (new ConsoleLoggerFactory())->create($output);

        $filesystem = new LocalFileSystem();
        $environment = new LocalEnvironment();
        $ciSystemsMap = DefaultSystems::map();
        $runnerFactory = new LinterRunnerFactory($environment, $ciSystemsMap, $logger, $metrics);

        $container = new MapContainer();

        $argResolverFactory = new ArgumentResolverFactory($container);

        $arrayConfigLoaderFactory = new ArrayConfigLoaderFactory($filesystem, $environment, $metrics, $argResolverFactory, $container);

        $configLoader = new CompositeLoader([
            'php' => new PhpLoader($filesystem),
            'json' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::JSON)),
            'yaml' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
            'yml' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
        ]);

        $configResolver = new MetricableConfigResolver(
            new ConfigResolver(new PathResolver($filesystem), $configLoader),
            $metrics,
        );

        $events = new EventDispatcher();

        $application->add(new LintCommand($configResolver, $runnerFactory, $metrics, $events));
        $application->add(new InstallCommand(new Copier(new Directory(__DIR__ . '/../../../../stubs'))));
        $application->add(new DumpCommand($configResolver, new RuleDumper()));
        $application->add(new InfoCommand(new ToolInfoFactory()));

        return $application;
    }
}
