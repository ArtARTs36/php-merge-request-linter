<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Report\MetricProxy;
use ArtARTs36\MergeRequestLinter\Report\MetricSubject;
use ArtARTs36\MergeRequestLinter\Support\Time\Timer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{
    public const VERSION = '0.6.0';

    public function __construct(
        private readonly MetricManager $metrics,
    ) {
        parent::__construct('Merge Request Linter', self::VERSION);
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        $timer = Timer::start();

        $this->metrics->add(
            new MetricSubject(
                sprintf('command_time_execution_%s', $command->getName() ?? 'main'),
                sprintf('Command "%s" execution', $command->getName()),
            ),
            $timeMetric = new MetricProxy(function () use ($timer) {
                return $timer->finish();
            }),
        );

        $result = parent::doRunCommand($command, $input, $output);

        $timeMetric->retrieveIfNotRetrieved();

        return $result;
    }
}
