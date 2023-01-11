<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ArrayConfigLoaderFactory;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\CompositeLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ConfigLoaderProxy;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\PhpConfigLoader;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\PathResolver;
use ArtARTs36\MergeRequestLinter\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InfoCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Environment\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Linter\Runner\RunnerFactory as LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Support\ToolInfo\ToolInfoFactory;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class ApplicationFactory
{
    public function create(OutputInterface $output): Application
    {
        $application = new Application();

        $logger = new ConsoleLogger($output);

        $filesystem = new LocalFileSystem();
        $environment = new LocalEnvironment();
        $ciSystemsMap = DefaultSystems::map();
        $runnerFactory = new LinterRunnerFactory($environment, $ciSystemsMap, $logger);

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
