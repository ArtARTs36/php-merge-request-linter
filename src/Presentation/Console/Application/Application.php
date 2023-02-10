<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Application;

use ArtARTs36\MergeRequestLinter\Common\Time\Timer;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricProxy;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{
    public function __construct(
        private readonly MetricManager $metrics,
    ) {
        parent::__construct('Merge Request Linter', Version::VERSION);
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        $timer = Timer::start();

        $this->metrics->add(
            new MetricSubject(
                sprintf('command_time_execution_%s', $command->getName() ?? 'main'),
                sprintf('[Console] Command "%s" execution', $command->getName()),
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
