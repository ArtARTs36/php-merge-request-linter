<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ArrayConfigLoaderFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\CompositeLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\PhpLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\MetricableConfigResolver;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\PathResolver;
use ArtARTs36\MergeRequestLinter\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InfoCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\IO\Console\ConsoleLoggerFactory;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory as LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Report\Reporter\ReporterFactory;
use ArtARTs36\MergeRequestLinter\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Support\File\Directory;
use ArtARTs36\MergeRequestLinter\Support\Http\ClientFactory;
use ArtARTs36\MergeRequestLinter\Support\ToolInfo\ToolInfoFactory;
use Symfony\Component\Console\Output\OutputInterface;

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

        $arrayConfigLoaderFactory = new ArrayConfigLoaderFactory($filesystem, $environment, $metrics);

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

        $application->add(new LintCommand($configResolver, $runnerFactory, $metrics, new ReporterFactory(
            new ClientFactory($metrics),
            $logger,
        )));
        $application->add(new InstallCommand(new Copier(new Directory(__DIR__ . '/../../../stubs'))));
        $application->add(new DumpCommand($configResolver, new RuleDumper()));
        $application->add(new InfoCommand(new ToolInfoFactory()));

        return $application;
    }
}
