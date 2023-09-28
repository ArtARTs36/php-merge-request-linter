<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Application;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\GaugeVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use ArtARTs36\MergeRequestLinter\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{
    public function __construct(
        private readonly GaugeVector $observer,
    ) {
        parent::__construct('Merge Request Linter', Version::VERSION);
    }

    public static function make(MetricManager $metrics): self
    {
        $observer = new GaugeVector(new MetricSubject(
            'console',
            'command_execution_time',
            'Command execution',
        ));

        $metrics->register($observer);

        return new self(
            $observer,
        );
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        $timer = Timer::start();

        $status = parent::doRunCommand($command, $input, $output);

        $this
            ->observer
            ->add(['command' => $command->getName() ?? 'main'])
            ->set($timer->finish()->seconds);

        return $status;
    }
}
