<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleFatalEndedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\Printer;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\ProgressBar;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LintEventsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ProgressBar $progressBar,
        private readonly Printer $printer,
        private readonly bool $isDebug,
    ) {
        //
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RuleWasSuccessfulEvent::class => 'succeed',
            RuleWasFailedEvent::class => 'failed',
            RuleFatalEndedEvent::class => 'failed',
            LintFinishedEvent::class => 'finished',
            ConfigResolvedEvent::class => 'configResolved',
        ];
    }

    public function succeed(): void
    {
        $this->progressBar->add();
    }

    public function failed(): void
    {
        $this->progressBar->add();
    }

    public function finished(LintFinishedEvent $event): void
    {
        $this->progressBar->finish();

        if (! $this->isDebug) {
            return;
        }

        $this->printer->line(1);
        $this->printer->printTitle('Merge Request properties:');
        $this->printer->printObject($event->request);
    }

    public function configResolved(ConfigResolvedEvent $event): void
    {
        $this->printer->printInfoLine(sprintf('Config path: %s', $event->config->path));

        $this->progressBar->max($event->config->config->getRules()->count());

        if ($this->isDebug) {
            $this->printer->line(2);

            $this->printer->printInfoLine(sprintf(
                'Used rules: %s',
                $event->config->config->getRules()->implodeNames(', '),
            ));

            $this->printer->line(2);
        }
    }
}
