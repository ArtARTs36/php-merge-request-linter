<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Application;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\LoggerFactory;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\RunnerFactory as LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\TaskHandlers\LintTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleDumper;
use ArtARTs36\MergeRequestLinter\Application\Rule\TaskHandlers\DumpTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\TaskHandlers\ShowToolInfoHandler;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\ArrayConfigLoaderFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\CompositeLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\MetricableConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\PathResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Logger\CompositeLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Logger\MetricableLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerRegistrar;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\NotifierFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\ArgumentResolverFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\DumpCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InfoCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\InstallCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Output\ConsoleLogger;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApplicationFactory
{
    public function __construct(
        private readonly MapContainer $container = new MapContainer(),
        private readonly Environment $environment = new LocalEnvironment(),
    ) {
        //
    }

    public function create(OutputInterface $output): Application
    {
        $clock = $this->registerClock();
        $metrics = $this->registerMetricManager();
        $logger = $this->createLogger($output, $metrics);

        $filesystem = $this->registerFileSystem();

        $ciSystemsMap = DefaultSystems::map();
        $httpClientFactory = $this->registerHttpClientFactory();
        $runnerFactory = new LinterRunnerFactory(
            $this->environment,
            $ciSystemsMap,
            $logger,
            $metrics,
            $httpClientFactory,
            $clock,
        );

        $argResolverFactory = new ArgumentResolverFactory($this->container);

        $arrayConfigLoaderFactory = new ArrayConfigLoaderFactory(
            $filesystem,
            $this->environment,
            $metrics,
            $argResolverFactory,
            $this->container,
        );

        $configLoader = new CompositeLoader([
            'json' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::JSON)),
            'yaml' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
            'yml' => new Proxy(static fn () => $arrayConfigLoaderFactory->create(ConfigFormat::YAML)),
        ]);

        $configResolver = new MetricableConfigResolver(
            new ConfigResolver(new PathResolver($filesystem), $configLoader),
            $metrics,
        );

        $events = $this->registerEventDispatcher();

        $this->registerNotifications();

        $application = new Application($metrics);

        $application->add(new LintCommand($metrics, $events, new LintTaskHandler(
            $configResolver,
            $events,
            new LinterFactory($events, $metrics),
            $runnerFactory,
        )));
        $application->add(new InstallCommand(new CreateConfigTaskHandler(new Copier(new Directory(__DIR__ . '/../../../../stubs')))));
        $application->add(new DumpCommand(new DumpTaskHandler($configResolver, new RuleDumper())));
        $application->add(new InfoCommand(new ShowToolInfoHandler(new ToolInfoFactory())));

        return $application;
    }

    /**
     * @throws \Exception
     */
    private function registerClock(): Clock
    {
        if (! $this->environment->has('MR_LINTER_TIMEZONE')) {
            $clock = LocalClock::utc();
        } else {
            $tzId = $this->environment->getString('MR_LINTER_TIMEZONE');

            try {
                $tz = new \DateTimeZone(trim($tzId));
            } catch (\Throwable) {
                throw new \Exception(sprintf('TimeZone "%s" invalid', $tzId));
            }

            $clock = new LocalClock($tz);
        }

        $this->container->set(ClockInterface::class, $clock);
        $this->container->set(Clock::class, $clock);

        return $clock;
    }

    private function registerNotifications(): void
    {
        $notificationsListener = function (ConfigResolvedEvent $event) {
            $this
                ->createNotificationsListenerRegistrar($event->config->config)
                ->register($this->container->get(EventManager::class));
        };

        $this
            ->container
            ->get(EventManager::class)
            ->listen(ConfigResolvedEvent::class, new CallbackListener(
                'registration notifications',
                $notificationsListener,
            ));
    }

    private function createNotificationsListenerRegistrar(Config $config): ListenerRegistrar
    {
        $logger = $this->container->get(ContextLogger::class);

        $notifier = (new NotifierFactory(
            $this->container->get(HttpClientFactory::class)->create(
                $config->getHttpClient()
            ),
            $this->container->get(ClockInterface::class),
            $logger,
        ))->create();

        return new ListenerRegistrar(
            $config->getNotifications(),
            new ListenerFactory(
                $notifier,
                $this->container->get(OperatorResolver::class),
                new MessageCreator(),
                $logger,
            ),
        );
    }

    private function registerHttpClientFactory(): ClientFactory
    {
        $factory = new ClientFactory(
            $this->container->get(MetricManager::class),
            $this->container->get(LoggerInterface::class),
        );

        $this->container->set(HttpClientFactory::class, $factory);
        $this->container->set(ClientFactory::class, $factory);

        return $factory;
    }

    private function registerEventDispatcher(): EventDispatcher
    {
        $ed = new EventDispatcher($this->container->get(ContextLogger::class));

        $this->container->set(EventDispatcher::class, $ed);
        $this->container->set(EventManager::class, $ed);

        return $ed;
    }

    private function registerMetricManager(): MetricManager
    {
        $metrics = new MemoryMetricManager($this->container->get(ClockInterface::class));

        $this->container->set(MetricManager::class, $metrics);

        return $metrics;
    }

    private function registerFileSystem(): FileSystem
    {
        $fs = new LocalFileSystem();

        $this->container->set(FileSystem::class, $fs);

        return $fs;
    }

    private function createLogger(OutputInterface $output, MetricManager $metricManager): ContextLogger
    {
        $loggers = [
            MetricableLogger::create($metricManager),
            new ConsoleLogger($output),
        ];

        $compositeLogger = new CompositeLogger($loggers);

        $logger = LoggerFactory::wrapInMemory($compositeLogger);

        $this->container->set(LoggerInterface::class, $logger);
        $this->container->set(ContextLogger::class, $logger);

        return $logger;
    }
}
